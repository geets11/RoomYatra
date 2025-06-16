<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\PathController;
use App\Http\Controllers\Website\PropertyController as WebsitePropertyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Landlord;
use App\Http\Controllers\Tenant;
use App\Http\Controllers\Subadmin;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Website Routes - Public Pages
Route::get("/", [PathController::class, 'home'])->name('home');
Route::get("/rooms", [WebsitePropertyController::class, 'index'])->name('rooms');
Route::get("/how-it-works", [PathController::class, 'howitworks'])->name('howitworks');
Route::get("/contact", [PathController::class, 'contact'])->name('contact');
Route::post("/contact", [PathController::class, 'submitContact'])->name('contact.submit');

// Public routes for footer links
Route::get('/resources', function () {
  return view('public.tenant-resources');
})->name('tenant-resources');

Route::get('/reviews', function () {
  return view('public.tenant-reviews');
})->name('tenant-reviews');

Route::get('/about', function () {
  return view('public.about');
})->name('about');

Route::get('/blog', function () {
  return view('public.blog');
})->name('blog');

Route::get('/privacy', function () {
  return view('public.privacy');
})->name('privacy');

Route::get('/terms', function () {
  return view('public.terms');
})->name('terms');

// Property Routes - Public Property Browsing
Route::get('/properties', [WebsitePropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [WebsitePropertyController::class, 'show'])->name('properties.show');

// Alternative route for property details
Route::get('/property/{property}', [WebsitePropertyController::class, 'show'])->name('property.show');
Route::get('/property/{id}/details', function($id) {
   $property = Property::findOrFail($id);
   return app(WebsitePropertyController::class)->show($property);
})->name('property.details');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password reset routes
Route::get('/password/reset', function () {
  return view('auth.passwords.email');
})->name('password.request');

Route::post('/password/email', function () {
  // Handle password reset email
})->name('password.email');

Route::get('/password/reset/{token}', function ($token) {
  return view('auth.passwords.reset', ['token' => $token]);
})->name('password.reset');

Route::post('/password/reset', function () {
  // Handle password reset
})->name('password.update');

// Debug Routes (Remove in production)
Route::get('/debug/images', function () {
  $properties = Property::with('images')->get();
  $debug = [];
  
  foreach ($properties as $property) {
      $debug[$property->id] = [
          'title' => $property->title,
          'images' => $property->images->map(function ($image) {
              return [
                  'path' => $image->image_path,
                  'exists' => Storage::disk('public')->exists($image->image_path),
                  'url' => Storage::disk('public')->url($image->image_path),
                  'full_path' => storage_path('app/public/' . $image->image_path),
                  'image_url_attribute' => $image->image_url,
              ];
          })
      ];
  }
  
  return response()->json($debug);
})->name('debug.images');

Route::get('/debug/storage', function () {
  $files = Storage::disk('public')->allFiles('property_images');
  return response()->json([
      'storage_path' => storage_path('app/public'),
      'public_path' => public_path('storage'),
      'link_exists' => is_link(public_path('storage')),
      'files' => $files
  ]);
})->name('debug.storage');

// Test route to check property details
Route::get('/test/property/{id}', function($id) {
   $property = Property::with(['images', 'propertyType', 'amenities', 'user'])->findOrFail($id);
   return response()->json([
       'property' => $property,
       'status' => $property->status,
       'can_view' => $property->status !== Property::STATUS_REJECTED,
       'images_count' => $property->images->count(),
       'first_image_url' => $property->images->first() ? $property->images->first()->image_url : null,
   ]);
})->name('test.property');

// Protected routes - Require Authentication
Route::middleware(['auth'])->group(function () {
  
  // Admin routes - Full system access
  Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
      // Dashboard
      Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

      // User management routes
      Route::resource('users', Admin\UserController::class);
      Route::patch('/users/{user}/toggle-status', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
      Route::delete('/users/{user}/force-delete', [Admin\UserController::class, 'forceDelete'])->name('users.force-delete');

      // Property management routes
      Route::get('/properties', [Admin\PropertyController::class, 'index'])->name('properties');
      Route::get('/properties/{property}', [Admin\PropertyController::class, 'show'])->name('properties.show');
      Route::get('/properties/{property}/view', [Admin\PropertyController::class, 'view'])->name('properties.view');
      Route::get('/properties/{property}/edit', [Admin\PropertyController::class, 'edit'])->name('properties.edit');
      Route::put('/properties/{property}', [Admin\PropertyController::class, 'update'])->name('properties.update');
      Route::delete('/properties/{property}', [Admin\PropertyController::class, 'destroy'])->name('properties.destroy');
      
      // Property status update routes
      Route::post('/properties/update-status', [Admin\PropertyController::class, 'updateStatus'])->name('properties.update-status');
      Route::post('/properties/status', [Admin\PropertyController::class, 'status'])->name('properties.status');
      Route::patch('/properties/{property}/approve', [Admin\PropertyController::class, 'approve'])->name('properties.approve');
      Route::patch('/properties/{property}/reject', [Admin\PropertyController::class, 'reject'])->name('properties.reject');

      // Booking management routes - FIXED: Simplified and consistent
      Route::get('/bookings', [Admin\BookingController::class, 'index'])->name('bookings.index');
      Route::get('/bookings/{booking}', [Admin\BookingController::class, 'show'])->name('bookings.show');
      Route::put('/bookings/{booking}/update-status', [Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
      Route::patch('/bookings/{booking}/approve', [Admin\BookingController::class, 'approve'])->name('bookings.approve');
      Route::patch('/bookings/{booking}/reject', [Admin\BookingController::class, 'reject'])->name('bookings.reject');
      Route::patch('/bookings/{booking}/complete', [Admin\BookingController::class, 'complete'])->name('bookings.complete');
      Route::patch('/bookings/{booking}/cancel', [Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
      
      // Reports routes
      Route::get('/reports', [Admin\ReportController::class, 'index'])->name('reports.index');
      Route::get('/reports/export', [Admin\ReportController::class, 'export'])->name('reports.export');
      Route::get('/reports/users', [Admin\ReportController::class, 'usersReport'])->name('reports.users');
      Route::get('/reports/properties', [Admin\ReportController::class, 'propertiesReport'])->name('reports.properties');
      Route::get('/reports/bookings', [Admin\ReportController::class, 'bookingsReport'])->name('reports.bookings');
      Route::get('/reports/revenue', [Admin\ReportController::class, 'revenueReport'])->name('reports.revenue');

      // Support ticket management
      Route::get('/support', [Admin\SupportController::class, 'index'])->name('support.index');
      Route::get('/support/{ticket}', [Admin\SupportController::class, 'show'])->name('support.show');
      Route::patch('/support/{ticket}/assign', [Admin\SupportController::class, 'assign'])->name('support.assign');
      Route::patch('/support/{ticket}/close', [Admin\SupportController::class, 'close'])->name('support.close');
      Route::post('/support/{ticket}/reply', [Admin\SupportController::class, 'reply'])->name('support.reply');

      // System settings
      Route::get('/settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
      Route::post('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');

      // Analytics and insights
      Route::get('/analytics', [Admin\AnalyticsController::class, 'index'])->name('analytics.index');
      Route::get('/insights', [Admin\InsightsController::class, 'index'])->name('insights.index');
  });

  // Subadmin routes - Limited admin access
  Route::middleware(['role:subadmin'])->prefix('subadmin')->name('subadmin.')->group(function () {
      // Dashboard
      Route::get('/dashboard', [DashboardController::class, 'subadmin'])->name('dashboard');
      
      // User management routes (limited)
      Route::resource('users', Subadmin\UserController::class)->except(['destroy']);
      Route::patch('/users/{user}/toggle-status', [Subadmin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
      
      // Property management routes (view only)
      Route::get('/properties', [Subadmin\PropertyController::class, 'index'])->name('properties.index');
      Route::get('/properties/{property}', [Subadmin\PropertyController::class, 'show'])->name('properties.show');
      Route::patch('/properties/{property}/update-status', [Subadmin\PropertyController::class, 'updateStatus'])->name('properties.update-status');
      Route::patch('/properties/{property}/approve', [Subadmin\PropertyController::class, 'approve'])->name('properties.approve');
      Route::patch('/properties/{property}/reject', [Subadmin\PropertyController::class, 'reject'])->name('properties.reject');
      
      // Booking management routes (limited)
      Route::get('/bookings', [Subadmin\BookingController::class, 'index'])->name('bookings.index');
      Route::get('/bookings/{booking}', [Subadmin\BookingController::class, 'show'])->name('bookings.show');
      Route::patch('/bookings/{booking}/update-status', [Subadmin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
      
      // Support ticket routes - FIXED: Added missing route
      Route::get('/support', [Subadmin\SupportController::class, 'index'])->name('support.index');
      Route::get('/support/{ticket}', [Subadmin\SupportController::class, 'show'])->name('support.show');
      Route::patch('/support/{ticket}/update-status', [Subadmin\SupportController::class, 'updateStatus'])->name('support.update-status');
      Route::post('/support/{ticket}/respond', [Subadmin\SupportController::class, 'respond'])->name('support.respond');
      Route::post('/support/{ticket}/reply', [Subadmin\SupportController::class, 'reply'])->name('support.reply');
      Route::patch('/support/{ticket}/assign', [Subadmin\SupportController::class, 'assign'])->name('support.assign');

      // Reports (limited access)
      Route::get('/reports', [Subadmin\ReportController::class, 'index'])->name('reports.index');
      Route::get('/reports/users', [Subadmin\ReportController::class, 'usersReport'])->name('reports.users');
      Route::get('/reports/properties', [Subadmin\ReportController::class, 'propertiesReport'])->name('reports.properties');

      // Settings (limited)
      Route::get('/settings', [Subadmin\SettingsController::class, 'index'])->name('settings.index');
      Route::post('/settings/profile', [Subadmin\SettingsController::class, 'updateProfile'])->name('settings.profile');
  });

  // Landlord routes - Property owners
  Route::middleware(['role:landlord'])->prefix('landlord')->name('landlord.')->group(function () {
      // Dashboard
      Route::get('/dashboard', [DashboardController::class, 'landlord'])->name('dashboard');

      // Property management routes (full CRUD for own properties)
      Route::resource('properties', Landlord\PropertyController::class);
      Route::post('/properties/{property}/images', [Landlord\PropertyController::class, 'uploadImages'])->name('properties.upload-images');
      Route::delete('/properties/{property}/images/{image}', [Landlord\PropertyController::class, 'deleteImage'])->name('properties.delete-image');
      Route::patch('/properties/{property}/toggle-status', [Landlord\PropertyController::class, 'toggleStatus'])->name('properties.toggle-status');

      // Booking management routes (for landlord's properties)
      Route::get('/bookings', [Landlord\BookingController::class, 'index'])->name('bookings.index');
      Route::get('/bookings/{booking}', [Landlord\BookingController::class, 'show'])->name('bookings.show');
      Route::patch('/bookings/{booking}/approve', [Landlord\BookingController::class, 'approve'])->name('bookings.approve');
      Route::patch('/bookings/{booking}/reject', [Landlord\BookingController::class, 'reject'])->name('bookings.reject');
      Route::patch('/bookings/{booking}/complete', [Landlord\BookingController::class, 'complete'])->name('bookings.complete');
      Route::patch('/bookings/{booking}/update-status', [Landlord\BookingController::class, 'updateStatus'])->name('bookings.update-status');
      Route::patch('/bookings/{booking}/mark-completed', [Landlord\BookingController::class, 'markCompleted'])->name('bookings.mark-completed');

      // Reviews management
      Route::get('/reviews', [Landlord\ReviewController::class, 'index'])->name('reviews.index');
      Route::get('/reviews/{review}', [Landlord\ReviewController::class, 'show'])->name('reviews.show');
      Route::post('/reviews/{review}/reply', [Landlord\ReviewController::class, 'reply'])->name('reviews.reply');

      // Support routes
      Route::get('/support', [Landlord\SupportController::class, 'index'])->name('support.index');
      Route::get('/support/create', [Landlord\SupportController::class, 'create'])->name('support.create');
      Route::post('/support', [Landlord\SupportController::class, 'store'])->name('support.store');
      Route::get('/support/{ticket}', [Landlord\SupportController::class, 'show'])->name('support.show');
      Route::get('/support/{ticket}/edit', [Landlord\SupportController::class, 'edit'])->name('support.edit');
      Route::put('/support/{ticket}', [Landlord\SupportController::class, 'update'])->name('support.update');
      Route::patch('/support/{ticket}/cancel', [Landlord\SupportController::class, 'cancel'])->name('support.cancel');
      Route::post('/support/{ticket}/reply', [Landlord\SupportController::class, 'reply'])->name('support.reply');

      // Analytics for landlord
      Route::get('/analytics', [Landlord\AnalyticsController::class, 'index'])->name('analytics.index');
      Route::get('/earnings', [Landlord\EarningsController::class, 'index'])->name('earnings.index');

      // Profile and settings
      Route::get('/profile', [Landlord\ProfileController::class, 'index'])->name('profile.index');
      Route::put('/profile', [Landlord\ProfileController::class, 'update'])->name('profile.update');
  });

  // Tenant routes - Property renters
  Route::middleware(['role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
      // Dashboard
      Route::get('/dashboard', [DashboardController::class, 'tenant'])->name('dashboard');

      // Booking routes
      Route::get('/bookings', [Tenant\BookingController::class, 'index'])->name('bookings.index');
      Route::get('/bookings/{booking}', [Tenant\BookingController::class, 'show'])->name('bookings.show');
      Route::get('/properties/{property}/book', [Tenant\BookingController::class, 'create'])->name('bookings.create');
      Route::post('/properties/{property}/book', [Tenant\BookingController::class, 'store'])->name('bookings.store');
      Route::patch('/bookings/{booking}/cancel', [Tenant\BookingController::class, 'cancel'])->name('bookings.cancel');
      Route::post('/bookings/{booking}/extend', [Tenant\BookingController::class, 'extend'])->name('bookings.extend');

      // Favorites
      Route::get('/favorites', [Tenant\FavoriteController::class, 'index'])->name('favorites.index');
      Route::post('/properties/{property}/favorite', [Tenant\FavoriteController::class, 'toggle'])->name('favorites.toggle');

      // Reviews
      Route::get('/reviews', [Tenant\ReviewController::class, 'index'])->name('reviews.index');
      Route::get('/reviews/create/{booking}', [Tenant\ReviewController::class, 'create'])->name('reviews.create');
      Route::post('/reviews/store/{booking}', [Tenant\ReviewController::class, 'store'])->name('reviews.store');
      Route::get('/reviews/{review}', [Tenant\ReviewController::class, 'show'])->name('reviews.show');
      Route::get('/reviews/{review}/edit', [Tenant\ReviewController::class, 'edit'])->name('reviews.edit');
      Route::patch('/reviews/{review}', [Tenant\ReviewController::class, 'update'])->name('reviews.update');
      Route::delete('/reviews/{review}', [Tenant\ReviewController::class, 'destroy'])->name('reviews.destroy');

      // Support routes
      Route::get('/support', [Tenant\SupportController::class, 'index'])->name('support.index');
      Route::get('/support/create', [Tenant\SupportController::class, 'create'])->name('support.create');
      Route::post('/support', [Tenant\SupportController::class, 'store'])->name('support.store');
      Route::get('/support/{ticket}', [Tenant\SupportController::class, 'show'])->name('support.show');
      Route::get('/support/{ticket}/edit', [Tenant\SupportController::class, 'edit'])->name('support.edit');
      Route::put('/support/{ticket}', [Tenant\SupportController::class, 'update'])->name('support.update');
      Route::patch('/support/{ticket}/cancel', [Tenant\SupportController::class, 'cancel'])->name('support.cancel');
      Route::post('/support/{ticket}/reply', [Tenant\SupportController::class, 'reply'])->name('support.reply');

      // Profile and settings
      Route::get('/profile', [Tenant\ProfileController::class, 'index'])->name('profile.index');
      Route::put('/profile', [Tenant\ProfileController::class, 'update'])->name('profile.update');
      Route::get('/settings', [Tenant\SettingsController::class, 'index'])->name('settings.index');
      Route::post('/settings', [Tenant\SettingsController::class, 'update'])->name('settings.update');

      // Payment routes
      Route::get('/payments', [Tenant\PaymentController::class, 'index'])->name('payments.index');
      Route::get('/payments/{payment}', [Tenant\PaymentController::class, 'show'])->name('payments.show');
      Route::post('/bookings/{booking}/pay', [Tenant\PaymentController::class, 'pay'])->name('payments.pay');
  });

  // Common authenticated user routes
  Route::get('/profile', function () {
      $user = auth()->user();
      $role = $user->roles->first()->name ?? 'user';
      
      switch ($role) {
          case 'admin':
              return redirect()->route('admin.dashboard');
          case 'subadmin':
              return redirect()->route('subadmin.dashboard');
          case 'landlord':
              return redirect()->route('landlord.dashboard');
          case 'tenant':
              return redirect()->route('tenant.dashboard');
          default:
              return redirect()->route('home');
      }
  })->name('profile');

  // Notifications
  Route::get('/notifications', function () {
      return auth()->user()->notifications;
  })->name('notifications.index');

  Route::patch('/notifications/{notification}/read', function ($notification) {
      auth()->user()->notifications()->where('id', $notification)->markAsRead();
      return response()->json(['success' => true]);
  })->name('notifications.read');
});

// API Routes for AJAX calls
Route::prefix('api')->middleware(['auth'])->group(function () {
  Route::get('/properties/search', [WebsitePropertyController::class, 'search'])->name('api.properties.search');
  Route::get('/cities', function () {
      return \App\Models\Property::distinct()->pluck('city');
  })->name('api.cities');
  
  Route::get('/property-types', function () {
      return \App\Models\PropertyType::all();
  })->name('api.property-types');
});

// Fallback route
Route::fallback(function () {
  return view('errors.404');
});
