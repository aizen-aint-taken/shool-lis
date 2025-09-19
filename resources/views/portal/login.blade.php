<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepEd LIS - Login</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 px-4 py-3 gap-3">
            <div class="flex items-center justify-between max-w-7xl mx-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-8 bg-red-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">DepEd</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-800 font-semibold text-lg">Learner Information System</span>
                        <div class="flex items-center space-x-2 text-sm text-blue-600">
                            <span>304866 - Maharlika National High School</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button 
                        onclick="openModal('sibo-modal')"
                        class="text-blue-600 hover:text-blue-800 text-sm mr-4 underline"
                        type="button"
                    >
                        About SIBO System
                    </button>
                    <a href="#" class="text-gray-600 hover:text-gray-800 text-sm">Help</a>
                </div>
            </div>  
        </div>

        <!-- Main Content -->
        <div class="flex justify-center items-center" style="min-height: calc(100vh - 120px);">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                    <h1 class="text-2xl font-normal text-gray-800 mb-8 text-center">Please sign in</h1>
                    
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        
                        @if($errors->has('login'))
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-sm">
                                {{ $errors->first('login') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <input type="text" 
                                   name="username"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Username"
                                   value="{{ old('username', 'admin1') }}"
                                   required>
                        </div>

                        <div class="mb-6">
                            <input type="password" 
                                   name="password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Password"
                                   value="password"
                                   required>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-sm font-medium transition duration-200">
                            Sign in
                        </button>
                    </form>

              
               

                    <div class="mt-8 p-4 bg-gray-50 rounded border">
                        <h3 class="font-medium text-gray-800 mb-2">Forgot password?</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            For class advisers, request School Head or designated school system administrator to reset password. 
                            For school heads, request Division Planning Officer to reset password.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center py-4 text-gray-500 text-sm">
            Department of Education - Learner Information System © {{ date('Y') }}
        </div>
    </div>

    {{-- SIBO System Information Modal --}}
    <div id="sibo-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
        {{-- Modal Content --}}
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 rounded-t-xl">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">
                            System for Integrated Basis of Grades and Output
                        </h2>
                        <p class="text-blue-100 text-lg">(SIBO)</p>
                    </div>
                    <button 
                        onclick="closeModal('sibo-modal')"
                        class="text-white hover:text-gray-200 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-8">
                {{-- Introduction Section --}}
                <section>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-blue-200 pb-2">
                        Introduction
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        The <strong>System for Integrated Basis of Grades and Output (SIBO)</strong> is a proposed 
                        innovation designed to extend and complement the existing <strong>Learner Information System (LIS) 
                        of the Department of Education (DepEd)</strong>. While the LIS primarily manages learner records, 
                        SIBO enhances its functionality by integrating grade-related forms, specifically <strong>School 
                        Forms (SF) 9 and SF 10</strong>, alongside other critical school forms such as 
                        <strong>SF 1, 2, 3, 5, and 8</strong>.
                    </p>
                </section>

                {{-- Role-Based Access Control Section --}}
                <section>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-blue-200 pb-2">
                        Role-Based Access Control (RBAC)
                    </h3>
                    <p class="text-gray-600 mb-4">
                        The system introduces a role-based access control structure to streamline responsibilities 
                        among different users:
                    </p>
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Subject Teachers --}}
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Subject Teachers</h4>
                                    <p class="text-sm text-gray-600">
                                        Can directly encode and update learners' grades and outputs in real-time.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Advisers --}}
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-500">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Advisers</h4>
                                    <p class="text-sm text-gray-600">
                                        Provided with tools to validate, consolidate, and monitor their class performance with greater accuracy.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Administrators --}}
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-purple-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Administrators</h4>
                                    <p class="text-sm text-gray-600">
                                        Gain oversight functions, ensuring compliance, accuracy, and integrity of records across all classes and levels.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Students --}}
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-orange-500">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-orange-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Students</h4>
                                    <p class="text-sm text-gray-600">
                                        Have secured access to view their academic progress and outputs, reducing dependence on manual distribution.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Hybrid Functionality Section --}}
                <section>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-blue-200 pb-2">
                        Hybrid Functionality
                    </h3>
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="flex items-center gap-2 bg-green-100 px-3 py-2 rounded-full">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                <span class="text-sm font-medium text-green-800">Offline Mode</span>
                            </div>
                            <div class="flex items-center gap-2 bg-blue-100 px-3 py-2 rounded-full">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-800">Online Sync</span>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            One of SIBO's distinct features is its <strong>hybrid functionality</strong>: it can operate 
                            <strong>offline</strong>, ensuring continuity even in low-connectivity areas, but requires an 
                            <strong>online connection for synchronization and updating</strong> to maintain data accuracy 
                            across the system.
                        </p>
                    </div>
                </section>

                {{-- Key Benefits Section --}}
                <section>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-blue-200 pb-2">
                        Key Benefits
                    </h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Eliminates manual checking and validation</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Reduces errors and redundancy</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Ensures efficiency and transparency</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Improves accountability in record management</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Unified digital platform for all school forms</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-700">Supports technology-driven practices</span>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- School Forms Integration Section --}}
                <section>
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b-2 border-blue-200 pb-2">
                        Integrated School Forms
                    </h3>
                    <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                        <p class="text-gray-700 mb-3">
                            By integrating all relevant school forms into a unified digital platform:
                        </p>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $forms = ['SF 1', 'SF 2', 'SF 3', 'SF 5', 'SF 8', 'SF 9', 'SF 10'];
                            @endphp
                            @foreach($forms as $form)
                                <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $form }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </section>

                {{-- System Goal Section --}}
                <section>
                    <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                        <h3 class="text-lg font-semibold text-blue-900 mb-3">System Goal</h3>
                        <p class="text-blue-800 leading-relaxed">
                            Ultimately, SIBO seeks to provide a <strong>reliable, efficient, and accessible digital solution</strong> 
                            that supports teachers, advisers, administrators, and students alike—bridging the gaps in DepEd's 
                            existing LIS framework while preparing the education sector for more streamlined and 
                            technology-driven practices.
                        </p>
                    </div>
                </section>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl">
                <div class="flex justify-end">
                    <button 
                        onclick="closeModal('sibo-modal')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Modal Functionality --}}
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore background scroll
        }

        // Close modal when clicking outside
        document.getElementById('sibo-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('sibo-modal');
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('sibo-modal');
            }
        });
    </script>
</body>
</html>
