<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->firstname }} {{ $member->surname }} - Member Profile</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #3699ff;
            --primary-dark: #254fd8;
            --secondary: #f3f6f9;
            --success: #1bc47d;
            --danger: #f64e60;
            --warning: #ffa800;
            --dark: #202124;
            --muted: #5f6368;
            --border: #d0d5dd;
            --gray-100: #f8f9fa;
            --gray-200: #f0f0f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            background: var(--secondary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--dark);
        }

        .profile-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .profile-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            max-width: 700px;
            width: 100%;
            overflow: hidden;
        }

        /* Header Section */
        .profile-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }

        .profile-image-wrapper {
            margin-bottom: 24px;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid white;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 5px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 56px;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .profile-header-info {
            margin-top: 16px;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .profile-title {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 16px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-position {
            font-size: 16px;
            margin-bottom: 16px;
            opacity: 0.95;
            font-weight: 600;
        }

        .category-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.25);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Body Section */
        .profile-body {
            padding: 40px;
        }

        .info-section {
            margin-bottom: 32px;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.5px;
        }

        .section-title i {
            color: var(--primary);
            font-size: 14px;
        }

        .info-row {
            display: flex;
            margin-bottom: 16px;
            align-items: flex-start;
            gap: 12px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: var(--secondary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
            font-size: 16px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }

        .info-value {
            font-size: 15px;
            color: var(--dark);
            font-weight: 600;
            word-break: break-word;
        }

        .info-value a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .info-value a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }

        /* Action Buttons Section */
        .action-section {
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .action-btn {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            font-size: 13px;
            text-align: center;
        }

        .action-btn-primary {
            background: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }

        .action-btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(54, 153, 255, 0.3);
            text-decoration: none;
            color: white;
        }

        .action-btn-secondary {
            background: var(--gray-100);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .action-btn-secondary:hover {
            background: var(--gray-200);
            border-color: var(--muted);
            text-decoration: none;
            color: var(--dark);
        }

        /* Footer */
        .profile-footer {
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            padding: 20px;
            border-top: 1px solid var(--border);
            background: var(--gray-100);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-body {
                padding: 28px;
            }

            .profile-header {
                padding: 32px 20px;
            }

            .profile-name {
                font-size: 24px;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            background: rgba(27, 196, 125, 0.1);
            color: var(--success);
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-left: 8px;
        }
    </style>
</head>
<body>
    <div class="profile-wrapper">
        <div class="profile-container">
            <div class="profile-card">
                <!-- Header with Image -->
                <div class="profile-header">
                    <div class="profile-image-wrapper">
                        @if($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->firstname }}" class="profile-avatar">
                        @else
                            <div class="avatar-placeholder">
                                {{ substr($member->firstname, 0, 1) }}{{ substr($member->surname, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="profile-header-info">
                        <div class="profile-name">
                            @if($member->title)
                                {{ $member->title }}
                            @endif
                            {{ $member->firstname }} {{ $member->surname }}
                        </div>

                        @if($member->position)
                            <div class="profile-position">
                                {{ $member->position }}
                            </div>
                        @endif

                        <span class="category-badge">
                            <i class="fas fa-id-badge"></i> {{ strtoupper($member->category) }}
                        </span>
                    </div>
                </div>

                <!-- Body with Information -->
                <div class="profile-body">
                    <!-- Personal Information -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-user-circle"></i> Personal Information
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Full Name</div>
                                <div class="info-value">
                                    @if($member->title)
                                        {{ $member->title }}
                                    @endif
                                    {{ $member->firstname }} 
                                    @if($member->middlename)
                                        {{ $member->middlename }}
                                    @endif
                                    {{ $member->surname }}
                                </div>
                            </div>
                        </div>

                        @if($member->dob)
                            <div class="info-row">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Date of Birth</div>
                                    <div class="info-value">{{ $member->dob->format('F d, Y') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Professional Information -->
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-briefcase"></i> Professional Information
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Position/Title</div>
                                <div class="info-value">{{ $member->position ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Category</div>
                                <div class="info-value">
                                    @if(strtoupper($member->category) === 'NWC')
                                        National Working Committee
                                    @elseif(strtoupper($member->category) === 'NEC')
                                        National Executive Committee
                                    @elseif(strtoupper($member->category) === 'DEP')
                                        Deputy
                                    @elseif(strtoupper($member->category) === 'STAFF')
                                        Staff Member
                                    @else
                                        {{ ucfirst(strtolower($member->category)) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    @if($member->phone)
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-phone"></i> Contact Information
                        </div>

                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Phone Number</div>
                                <div class="info-value">
                                    <a href="tel:{{ $member->phone }}">{{ $member->phone }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Location Information -->
                    @if($member->state || $member->pscode)
                    <div class="info-section">
                        <div class="section-title">
                            <i class="fas fa-map-marker-alt"></i> Location Information
                        </div>

                        <div class="grid-2">
                            @if($member->state)
                                <div class="info-row">
                                    <div class="info-icon">
                                        <i class="fas fa-map"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">State/Province</div>
                                        <div class="info-value">{{ $member->state }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($member->pscode)
                                <div class="info-row">
                                    <div class="info-icon">
                                        <i class="fas fa-mailbox"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">Postal Code</div>
                                        <div class="info-value">{{ $member->pscode }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($member->phone)
                    <div class="action-section">
                        <div class="action-buttons">
                            <a href="tel:{{ $member->phone }}" class="action-btn action-btn-primary">
                                <i class="fas fa-phone"></i> Call
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" class="action-btn action-btn-secondary">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="profile-footer">
                    <i class="fas fa-shield-alt"></i> Member Profile • {{ now()->format('Y') }} • Public Access
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
