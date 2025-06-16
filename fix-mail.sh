#!/bin/bash

echo "🔧 Fixing RoomYatra Mail Configuration..."

# Backup current .env
cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
echo "✅ Backed up current .env file"

# Update .env file for development
echo "📝 Updating .env file for development..."

# Remove or comment out problematic mail settings
sed -i.bak 's/^MAIL_HOST=mailpit/# MAIL_HOST=mailpit/' .env
sed -i.bak 's/^MAIL_PORT=1025/# MAIL_PORT=1025/' .env

# Add or update mail settings for development
if grep -q "^MAIL_MAILER=" .env; then
    sed -i.bak 's/^MAIL_MAILER=.*/MAIL_MAILER=log/' .env
else
    echo "MAIL_MAILER=log" >> .env
fi

if grep -q "^MAIL_FROM_ADDRESS=" .env; then
    sed -i.bak 's/^MAIL_FROM_ADDRESS=.*/MAIL_FROM_ADDRESS=noreply@roomyatra.local/' .env
else
    echo "MAIL_FROM_ADDRESS=noreply@roomyatra.local" >> .env
fi

if grep -q "^MAIL_FROM_NAME=" .env; then
    sed -i.bak 's/^MAIL_FROM_NAME=.*/MAIL_FROM_NAME="RoomYatra"/' .env
else
    echo 'MAIL_FROM_NAME="RoomYatra"' >> .env
fi

echo "✅ Updated .env file"

# Clear config cache
echo "🧹 Clearing configuration cache..."
php artisan config:clear

echo "✅ Configuration cache cleared"

# Test email
echo "📧 Testing email configuration..."
php artisan test:email

echo "🎉 Mail configuration fix completed!"
echo ""
echo "📋 What was changed:"
echo "   - Set MAIL_MAILER to 'log' (emails will be logged instead of sent)"
echo "   - Disabled mailpit configuration"
echo "   - Set proper FROM address and name"
echo ""
echo "📁 Emails will now be logged to: storage/logs/laravel.log"
echo "🔄 To revert changes, restore from backup: .env.backup.*"
