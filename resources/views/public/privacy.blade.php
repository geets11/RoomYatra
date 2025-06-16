@extends('website.layouts.app')

@section('title', 'Privacy Policy - RoomYatra')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="bg-rose-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl">Privacy Policy</h1>
                    <p class="mt-4 text-xl text-gray-300">How we collect, use, and protect your information</p>
                    <p class="mt-2 text-sm text-gray-400">Last updated: December 31, 2024</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="prose prose-lg max-w-none">

                    <!-- Introduction -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                        <p class="text-gray-600 leading-relaxed">
                            At RoomYatra, we are committed to protecting your privacy and ensuring the security of your
                            personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard
                            your information when you use our platform, website, and services.
                        </p>
                        <p class="text-gray-600 leading-relaxed mt-4">
                            By using RoomYatra, you consent to the data practices described in this policy. If you do not
                            agree with the practices described in this policy, please do not use our services.
                        </p>
                    </div>

                    <!-- Information We Collect -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Personal Information</h3>
                        <p class="text-gray-600 mb-4">We may collect the following personal information:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Name, email address, and phone number</li>
                            <li>Profile information and photos</li>
                            <li>Government-issued identification documents</li>
                            <li>Payment information and billing details</li>
                            <li>Property information and photos (for landlords)</li>
                            <li>Communication preferences</li>
                        </ul>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3 mt-6">Usage Information</h3>
                        <p class="text-gray-600 mb-4">We automatically collect certain information about your use of our
                            services:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Device information (IP address, browser type, operating system)</li>
                            <li>Usage patterns and preferences</li>
                            <li>Location data (with your permission)</li>
                            <li>Cookies and similar tracking technologies</li>
                            <li>Log files and analytics data</li>
                        </ul>
                    </div>

                    <!-- How We Use Information -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Your Information</h2>
                        <p class="text-gray-600 mb-4">We use the collected information for the following purposes:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Provide and maintain our services</li>
                            <li>Process transactions and payments</li>
                            <li>Verify user identity and prevent fraud</li>
                            <li>Communicate with you about our services</li>
                            <li>Send notifications and updates</li>
                            <li>Improve our platform and user experience</li>
                            <li>Comply with legal obligations</li>
                            <li>Resolve disputes and enforce agreements</li>
                        </ul>
                    </div>

                    <!-- Information Sharing -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Information Sharing and Disclosure</h2>
                        <p class="text-gray-600 mb-4">We may share your information in the following circumstances:</p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">With Other Users</h3>
                        <p class="text-gray-600 mb-4">
                            When you use our platform, certain information may be shared with other users to facilitate
                            bookings and communications (e.g., your name and profile information with landlords when you
                            make a booking request).
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Service Providers</h3>
                        <p class="text-gray-600 mb-4">
                            We may share information with third-party service providers who help us operate our platform,
                            including payment processors, hosting services, and analytics providers.
                        </p>

                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Legal Requirements</h3>
                        <p class="text-gray-600 mb-4">
                            We may disclose information when required by law, court order, or government request, or to
                            protect our rights, property, or safety.
                        </p>
                    </div>

                    <!-- Data Security -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Security</h2>
                        <p class="text-gray-600 mb-4">
                            We implement appropriate technical and organizational measures to protect your personal
                            information against unauthorized access, alteration, disclosure, or destruction. These measures
                            include:
                        </p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Encryption of sensitive data in transit and at rest</li>
                            <li>Regular security assessments and updates</li>
                            <li>Access controls and authentication measures</li>
                            <li>Employee training on data protection</li>
                            <li>Secure data centers and infrastructure</li>
                        </ul>
                        <p class="text-gray-600 mt-4">
                            However, no method of transmission over the internet or electronic storage is 100% secure. While
                            we strive to protect your information, we cannot guarantee absolute security.
                        </p>
                    </div>

                    <!-- Your Rights -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights and Choices</h2>
                        <p class="text-gray-600 mb-4">You have the following rights regarding your personal information:</p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li><strong>Access:</strong> Request access to your personal information</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                            <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                            <li><strong>Portability:</strong> Request a copy of your data in a portable format</li>
                            <li><strong>Objection:</strong> Object to certain processing of your information</li>
                            <li><strong>Restriction:</strong> Request restriction of processing</li>
                        </ul>
                        <p class="text-gray-600 mt-4">
                            To exercise these rights, please contact us using the information provided in the "Contact Us"
                            section below.
                        </p>
                    </div>

                    <!-- Cookies -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies and Tracking Technologies</h2>
                        <p class="text-gray-600 mb-4">
                            We use cookies and similar tracking technologies to enhance your experience on our platform.
                            Cookies are small data files stored on your device that help us:
                        </p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Remember your preferences and settings</li>
                            <li>Analyze site traffic and usage patterns</li>
                            <li>Provide personalized content and recommendations</li>
                            <li>Improve our services and user experience</li>
                        </ul>
                        <p class="text-gray-600 mt-4">
                            You can control cookie settings through your browser preferences. However, disabling cookies may
                            affect the functionality of our platform.
                        </p>
                    </div>

                    <!-- Data Retention -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Retention</h2>
                        <p class="text-gray-600 mb-4">
                            We retain your personal information for as long as necessary to provide our services and fulfill
                            the purposes outlined in this policy. Specific retention periods depend on the type of
                            information and the purpose for which it was collected:
                        </p>
                        <ul class="list-disc pl-6 text-gray-600 space-y-2">
                            <li>Account information: Until account deletion or as required by law</li>
                            <li>Transaction records: 7 years for tax and legal compliance</li>
                            <li>Communication logs: 3 years for customer service purposes</li>
                            <li>Marketing data: Until you opt out or as required by law</li>
                        </ul>
                    </div>

                    <!-- International Transfers -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">International Data Transfers</h2>
                        <p class="text-gray-600 mb-4">
                            Your information may be transferred to and processed in countries other than your country of
                            residence. We ensure that such transfers comply with applicable data protection laws and
                            implement appropriate safeguards to protect your information.
                        </p>
                    </div>

                    <!-- Children's Privacy -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Children's Privacy</h2>
                        <p class="text-gray-600 mb-4">
                            Our services are not intended for individuals under the age of 18. We do not knowingly collect
                            personal information from children under 18. If we become aware that we have collected personal
                            information from a child under 18, we will take steps to delete such information.
                        </p>
                    </div>

                    <!-- Changes to Policy -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to This Privacy Policy</h2>
                        <p class="text-gray-600 mb-4">
                            We may update this Privacy Policy from time to time to reflect changes in our practices or
                            applicable laws. We will notify you of any material changes by posting the updated policy on our
                            website and updating the "Last updated" date. Your continued use of our services after such
                            changes constitutes acceptance of the updated policy.
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                        <p class="text-gray-600 mb-4">
                            If you have any questions about this Privacy Policy or our data practices, please contact us:
                        </p>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <p class="text-gray-600"><strong>Email:</strong> privacy@roomyatra.com</p>
                            <p class="text-gray-600"><strong>Phone:</strong> +1 (555) 123-4567</p>
                            <p class="text-gray-600"><strong>Address:</strong> 123 Privacy Street, Data City, DC 12345</p>
                            <p class="text-gray-600"><strong>Data Protection Officer:</strong> dpo@roomyatra.com</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 text-center">Related Policies</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="/terms-of-service"
                        class="bg-white px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-shadow text-rose-600 hover:text-rose-700 font-medium">
                        Terms of Service
                    </a>
                    <a href="/cookie-policy"
                        class="bg-white px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-shadow text-rose-600 hover:text-rose-700 font-medium">
                        Cookie Policy
                    </a>
                    <a href="/contact"
                        class="bg-white px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-shadow text-rose-600 hover:text-rose-700 font-medium">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
