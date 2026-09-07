<x-default-layout>

    @section('title')
        Attendance Check-In - {{ $meeting->title }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('meetings.attendance-scan', $meeting) }}
    @endsection

    <style>
        .scanner-section {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 20px;
        }

        .scanner-label {
            font-size: 14px;
            font-weight: 600;
            color: #202124;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .scanner-label i {
            color: #3699ff;
            font-size: 18px;
        }

        #reader {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            background: #000;
            min-height: 350px;
            margin-bottom: 16px;
        }

        .scanner-controls {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .camera-trigger {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3699ff 0%, #254fd8 100%);
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(54, 153, 255, 0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            transition: all 0.2s;
            margin: 0 auto;
        }

        .camera-trigger:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(54, 153, 255, 0.4);
        }

        .camera-trigger:active {
            transform: scale(0.95);
        }

        .camera-status {
            text-align: center;
            padding: 8px 12px;
            background: #f3f5ff;
            border-radius: 6px;
            font-size: 12px;
            color: #3699ff;
            font-weight: 600;
            display: none;
        }

        .camera-status.active {
            display: block;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .manual-input-section {
            border-top: 1px solid #e0e0e0;
            padding-top: 16px;
        }

        .input-label {
            font-size: 12px;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .manual-input-group {
            display: flex;
            gap: 8px;
        }

        .manual-input-group input {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #d0d5dd;
            border-radius: 6px;
            font-size: 13px;
            font-family: monospace;
            letter-spacing: 0.5px;
            transition: border-color 0.2s;
        }

        .manual-input-group input:focus {
            outline: none;
            border-color: #3699ff;
            box-shadow: 0 0 0 3px rgba(54, 153, 255, 0.1);
        }

        .manual-input-group button {
            padding: 10px 16px;
            background: #3699ff;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .manual-input-group button:hover {
            background: #254fd8;
        }

        .manual-input-group button:active {
            transform: scale(0.98);
        }

        .info-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 16px;
        }

        .info-card h3 {
            font-size: 12px;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 12px 0;
            font-weight: 600;
        }

        .meeting-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .detail-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            font-size: 13px;
        }

        .detail-item i {
            color: #3699ff;
            font-size: 14px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .detail-text {
            flex: 1;
        }

        .detail-label {
            color: #5f6368;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            color: #202124;
            font-weight: 600;
            font-size: 13px;
        }

        .result-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            border-left: 4px solid #1bc47d;
            display: none;
            animation: slideDown 0.3s ease;
            cursor: pointer;
            transition: all 0.2s;
        }

        .result-card:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .result-card.error {
            border-left-color: #f64e60;
        }

        .result-card.show {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .result-header {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            align-items: flex-start;
        }

        .result-icon {
            font-size: 28px;
            flex-shrink: 0;
        }

        .result-success .result-icon {
            color: #1bc47d;
        }

        .result-error .result-icon {
            color: #f64e60;
        }

        .result-text h4 {
            font-size: 14px;
            font-weight: 600;
            color: #202124;
            margin: 0 0 4px 0;
        }

        .result-text p {
            font-size: 12px;
            color: #5f6368;
            margin: 0;
        }

        .result-member {
            display: flex;
            gap: 12px;
            padding: 12px;
            background: #f3f6f9;
            border-radius: 6px;
        }

        .member-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .member-info {
            flex: 1;
        }

        .member-name {
            font-weight: 600;
            font-size: 13px;
            color: #202124;
            margin: 0 0 4px 0;
        }

        .member-detail {
            font-size: 12px;
            color: #5f6368;
            margin: 0 0 6px 0;
        }

        .seat-badge {
            display: inline-block;
            background: #3699ff;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
        }

        .stats-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #3699ff;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .recent-checkins {
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .recent-checkins h3 {
            font-size: 12px;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 12px 0;
            font-weight: 600;
        }

        .checkin-item {
            display: flex;
            gap: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
            cursor: pointer;
            transition: background 0.2s;
            padding: 8px;
            margin: 0 -8px;
            border-radius: 4px;
        }

        .checkin-item:hover {
            background: #f8f9fa;
        }

        .checkin-item:last-child {
            border-bottom: none;
        }

        .checkin-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .checkin-details {
            flex: 1;
            min-width: 0;
        }

        .checkin-name {
            font-size: 12px;
            font-weight: 600;
            color: #202124;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .checkin-time {
            font-size: 11px;
            color: #5f6368;
            margin: 0;
        }

        .checkin-badge {
            background: #1bc47d;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            flex-shrink: 0;
        }

        /* Member Profile Modal Styles */
        .member-profile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .member-profile-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .member-profile-card {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            background: linear-gradient(135deg, #3699ff 0%, #254fd8 100%);
            padding: 24px 20px;
            position: relative;
            border-radius: 12px 12px 0 0;
        }

        .profile-close {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .profile-close .btn-close {
            filter: brightness(0) invert(1);
        }

        .profile-image-section {
            display: flex;
            justify-content: center;
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .profile-status {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            border-radius: 50%;
            padding: 4px;
        }

        .profile-status .badge {
            font-size: 11px;
            padding: 4px 8px;
        }

        .profile-body {
            padding: 24px 20px;
        }

        .profile-name-section {
            text-align: center;
            margin-bottom: 24px;
            border-bottom: 2px solid #f3f6f9;
            padding-bottom: 16px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: 700;
            color: #202124;
            margin: 0 0 8px 0;
        }

        .profile-position {
            font-size: 14px;
            color: #3699ff;
            font-weight: 600;
            margin: 0;
        }

        .profile-section {
            margin-bottom: 20px;
        }

        .profile-section:last-child {
            margin-bottom: 0;
        }

        .profile-section-title {
            font-size: 12px;
            font-weight: 600;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .profile-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .profile-detail-row .detail-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .profile-detail-row .detail-label i {
            color: #3699ff;
            font-size: 14px;
            width: 20px;
        }

        .profile-detail-row .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: #202124;
            text-align: right;
        }

        @media (max-width: 768px) {
            .stats-header {
                grid-template-columns: 1fr;
            }

            #reader {
                min-height: 250px;
            }

            .member-profile-card {
                width: 95%;
                max-height: 95vh;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-name {
                font-size: 20px;
            }
        }
    </style>

    <div class="row g-5 g-xl-10 mb-5">
        <!-- Stats -->
        <div class="col-12">
            <div class="stats-header">
                <div class="stat-card">
                    <div class="stat-number" id="liveCount">0</div>
                    <div class="stat-label">Members Present</div>
                </div>
                @if($meeting->total_seats)
                <div class="stat-card">
                    <div class="stat-number">{{ $meeting->total_seats }}</div>
                    <div class="stat-label">Total Seats</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-5 g-xl-10">
        <!-- Left Column: Scanner -->
        <div class="col-lg-8">
            <div class="scanner-section">
                <label class="scanner-label">
                    {!! getIcon('camera', 'fs-4') !!}
                    Scan Member QR Code
                </label>
                
                <!-- QR Reader -->
                <div id="reader"></div>

                <!-- Camera Controls -->
                <div class="scanner-controls">
                    <button id="cameraTrigger" class="camera-trigger" type="button" title="Toggle Camera">
                        <i class="fas fa-camera"></i>
                    </button>
                    <div id="cameraStatus" class="camera-status">
                        🔴 Camera Active - Scanning...
                    </div>
                </div>

                <!-- Manual Input -->
                <div class="manual-input-section">
                    <label class="input-label">Or paste member UUID or profile URL:</label>
                    <div class="manual-input-group">
                        <input 
                            type="text" 
                            id="manualInput" 
                            placeholder="Paste UUID or full profile URL"
                            autocomplete="off"
                            autofocus
                        />
                        <button type="button" onclick="handleManualInput()" title="Submit UUID or URL">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Info & Results -->
        <div class="col-lg-4">
            <!-- Meeting Info Card -->
            <div class="info-card">
                <h3>Meeting Information</h3>
                <div class="meeting-details">
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="detail-text">
                            <div class="detail-label">Date & Time</div>
                            <div class="detail-value">{{ $meeting->scheduled_at->format('M d, Y @ H:i') }}</div>
                        </div>
                    </div>
                    @if($meeting->location)
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="detail-text">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $meeting->location }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="detail-item">
                        <i class="fas fa-info-circle"></i>
                        <div class="detail-text">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                @if($meeting->status === 'scheduled')
                                    <span class="badge bg-light-warning">Scheduled</span>
                                @elseif($meeting->status === 'ongoing')
                                    <span class="badge bg-light-success">Ongoing</span>
                                @else
                                    <span class="badge bg-light-secondary">Completed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Result Card -->
            <div id="resultCard" class="result-card result-success" onclick="showMemberProfile()">
                <div class="result-header">
                    <div class="result-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="result-text">
                        <h4 id="resultTitle">Member Checked In</h4>
                        <p id="resultSubtitle">Click to view full profile</p>
                    </div>
                </div>
                <div id="memberCard" class="result-member"></div>
            </div>

            <!-- Recent Check-ins -->
            <div class="recent-checkins">
                <h3>Recent Check-ins</h3>
                <div id="recentCheckins">
                    <div style="text-align: center; color: #5f6368; padding: 20px 0;">
                        <p style="margin: 0; font-size: 12px;">No check-ins yet</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Member Profile Modal -->
    <div class="member-profile-overlay" id="profileOverlay" onclick="closeMemberProfile(event)">
        <div class="member-profile-card" onclick="event.stopPropagation()">
            <div class="profile-header">
                <div class="profile-close">
                    <button type="button" class="btn-close" onclick="closeMemberProfile()"></button>
                </div>
                <div class="profile-image-section">
                    <img id="profileImage" src="" alt="Member Profile" class="profile-avatar">
                    <div class="profile-status">
                        <span class="badge bg-success"><i class="fas fa-check"></i> Present</span>
                    </div>
                </div>
            </div>

            <div class="profile-body">
                <!-- Member Name & Position -->
                <div class="profile-name-section">
                    <h2 id="profileName" class="profile-name">John Doe</h2>
                    <p id="profilePositionText" class="profile-position">Executive Director</p>
                </div>

                <!-- Personal Information -->
                <div class="profile-section">
                    <h4 class="profile-section-title">Personal Information</h4>
                    <div class="profile-details">
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-phone"></i> Phone
                            </div>
                            <div class="detail-value" id="profilePhone">-</div>
                        </div>
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-birthday-cake"></i> DOB
                            </div>
                            <div class="detail-value" id="profileDOB">-</div>
                        </div>
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-map-marker-alt"></i> State
                            </div>
                            <div class="detail-value" id="profileState">-</div>
                        </div>
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-mailbox"></i> Postal Code
                            </div>
                            <div class="detail-value" id="profilePostalCode">-</div>
                        </div>
                    </div>
                </div>

                <!-- Member Details -->
                <div class="profile-section">
                    <h4 class="profile-section-title">Member Details</h4>
                    <div class="profile-details">
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-id-card"></i> Category
                            </div>
                            <div class="detail-value" id="profileCategory">-</div>
                        </div>
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-chair"></i> Seat
                            </div>
                            <div class="detail-value" id="profileSeatNumber">-</div>
                        </div>
                    </div>
                </div>

                <!-- Meeting Check-In Information -->
                <div class="profile-section">
                    <h4 class="profile-section-title">Check-In Details</h4>
                    <div class="profile-details">
                        <div class="profile-detail-row">
                            <div class="detail-label">
                                <i class="fas fa-calendar-check"></i> Check-in Time
                            </div>
                            <div class="detail-value" id="profileCheckinTime">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        console.log('🚀 Scanner page loaded');
        
        let lastScannedUuid = null;
        let scanTimeout = null;
        let isScanningPaused = false;
        let recentCheckinsData = [];
        let currentMemberData = null;

        // Initialize QR Scanner
        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { facingMode: "environment", qrbox: { width: 300, height: 300 } },
            false
        );

        html5QrcodeScanner.render(onScanSuccess, onScanError);
        console.log('✓ QR Scanner initialized');

        // Camera Toggle Button
        const cameraTrigger = document.getElementById('cameraTrigger');
        const cameraStatus = document.getElementById('cameraStatus');
        const manualInput = document.getElementById('manualInput');

        cameraTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (!isScanningPaused) {
                html5QrcodeScanner.pause(true);
                isScanningPaused = true;
                cameraTrigger.style.opacity = '0.5';
                cameraTrigger.style.transform = 'scale(0.9)';
                cameraStatus.textContent = '⏸️ Camera Paused';
                cameraStatus.classList.remove('active');
                manualInput.placeholder = 'Camera paused - Paste UUID or click to resume';
            } else {
                html5QrcodeScanner.resume();
                isScanningPaused = false;
                cameraTrigger.style.opacity = '1';
                cameraTrigger.style.transform = 'scale(1)';
                cameraStatus.textContent = '🔴 Camera Active - Scanning...';
                cameraStatus.classList.add('active');
                manualInput.placeholder = 'e.g., 959d1c08-99b1-4102-9575-079c043a6948';
                manualInput.focus();
            }
        });

        // Show camera status
        cameraStatus.classList.add('active');

        // Auto-listening input field (works with USB scanner)
        manualInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                handleManualInput();
            }
        });

        function onScanSuccess(decodedText, decodedResult) {
            if (isScanningPaused) return;

            if (lastScannedUuid === decodedText) {
                return;
            }

            const uuidMatch = decodedText.match(/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i);
            
            if (uuidMatch) {
                lastScannedUuid = uuidMatch[0];
                manualInput.value = lastScannedUuid;
                
                cameraTrigger.style.background = 'linear-gradient(135deg, #1bc47d 0%, #0f652d 100%)';
                cameraTrigger.innerHTML = '<i class="fas fa-check"></i>';
                
                checkInMember(lastScannedUuid);
                
                clearTimeout(scanTimeout);
                scanTimeout = setTimeout(() => {
                    lastScannedUuid = null;
                    manualInput.value = '';
                    
                    cameraTrigger.style.background = 'linear-gradient(135deg, #3699ff 0%, #254fd8 100%)';
                    cameraTrigger.innerHTML = '<i class="fas fa-camera"></i>';
                    
                    manualInput.focus();
                }, 2000);
            }
        }

        function onScanError(error) {
            // Silent fail - errors are expected
        }

        function handleManualInput() {
            let input = manualInput.value.trim();
            
            // Extract UUID from URL if it's a full URL
            let uuid = extractUuidFromInput(input);
            
            if (uuid && /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i.test(uuid)) {
                checkInMember(uuid);
                manualInput.value = '';
            } else {
                manualInput.style.borderColor = '#f64e60';
                setTimeout(() => {
                    manualInput.style.borderColor = '#d0d5dd';
                }, 500);
            }
        }

        function extractUuidFromInput(input) {
            // Pattern to match UUID in various formats
            const uuidPattern = /[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/i;
            const match = input.match(uuidPattern);
            
            if (match) {
                console.log('UUID extracted from input:', match[0]);
                return match[0];
            }
            
            return input; // Return original if no UUID pattern found (might be a bare UUID)
        }

        function checkInMember(memberUuid) {
            const meetingUuid = "{{ $meeting->public_uuid }}";
            console.log('Checking in member:', memberUuid);
            
            fetch(`/meetings/${meetingUuid}/check-in`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ member_uuid: memberUuid })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                if (data.success) {
                    showResult(data);
                    updateLiveCount(data.meeting_attendance);
                    addRecentCheckin(data.member);
                    currentMemberData = data.member;
                } else {
                    console.error('Check-in failed:', data.message);
                    showErrorResult(data.message || 'Check-in failed');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showErrorResult('Error: ' + error.message);
            });
        }

        function showResult(data) {
            const resultCard = document.getElementById('resultCard');
            const resultTitle = document.getElementById('resultTitle');
            const resultSubtitle = document.getElementById('resultSubtitle');
            const memberCard = document.getElementById('memberCard');

            if (data.success) {
                resultCard.classList.remove('error');
                resultTitle.textContent = 'Check-in Successful!';
                resultSubtitle.textContent = 'Click to view full profile';
            } else {
                resultCard.classList.add('error');
                resultTitle.textContent = 'Check-in Failed';
                resultSubtitle.textContent = data.message;
            }

            let memberHtml = '';

            if (data.member.image) {
                memberHtml += `<img src="${data.member.image}" alt="${data.member.name}" class="member-avatar">`;
            }

            memberHtml += `
                <div class="member-info">
                    <p class="member-name">${data.member.name}</p>
                    <p class="member-detail"><i class="fas fa-briefcase"></i> ${data.member.position}</p>
            `;

            if (data.member.seat) {
                memberHtml += `
                    <span class="seat-badge"><i class="fas fa-chair"></i> Seat #${data.member.seat}</span>
                `;
            }

            memberHtml += `</div>`;

            memberCard.innerHTML = memberHtml;
            resultCard.classList.add('show');
        }

        function showErrorResult(message) {
            const resultCard = document.getElementById('resultCard');
            const resultTitle = document.getElementById('resultTitle');
            const resultSubtitle = document.getElementById('resultSubtitle');

            resultCard.classList.add('error');
            resultTitle.textContent = 'Error';
            resultSubtitle.textContent = message;
            resultCard.classList.add('show');
        }

        function showMemberProfile() {
            if (!currentMemberData) return;

            const overlay = document.getElementById('profileOverlay');
            
            // Set profile data
            document.getElementById('profileImage').src = currentMemberData.image || 'https://via.placeholder.com/120';
            document.getElementById('profileName').textContent = currentMemberData.full_name || currentMemberData.name;
            document.getElementById('profilePositionText').textContent = currentMemberData.position || '-';
            document.getElementById('profilePhone').textContent = currentMemberData.phone || '-';
            document.getElementById('profileDOB').textContent = currentMemberData.dob || '-';
            document.getElementById('profileState').textContent = currentMemberData.state || '-';
            document.getElementById('profilePostalCode').textContent = currentMemberData.pscode || '-';
            document.getElementById('profileCategory').textContent = (currentMemberData.category || '-').toUpperCase();
            document.getElementById('profileSeatNumber').textContent = currentMemberData.seat ? `#${currentMemberData.seat}` : '-';
            document.getElementById('profileCheckinTime').textContent = currentMemberData.checked_in_at || '-';

            overlay.classList.add('active');
        }

        function closeMemberProfile(event) {
            if (event && event.target.id !== 'profileOverlay') {
                return;
            }
            document.getElementById('profileOverlay').classList.remove('active');
        }

        // Close profile when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMemberProfile();
            }
        });

        function updateLiveCount(count) {
            document.getElementById('liveCount').textContent = count;
        }

        function addRecentCheckin(member) {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            recentCheckinsData.unshift({
                name: member.name,
                image: member.image,
                time: timeStr,
                data: member
            });

            // Keep only last 5
            if (recentCheckinsData.length > 5) {
                recentCheckinsData.pop();
            }

            updateRecentCheckins();
        }

        function updateRecentCheckins() {
            const container = document.getElementById('recentCheckins');
            
            if (recentCheckinsData.length === 0) {
                container.innerHTML = `
                    <div style="text-align: center; color: #5f6368; padding: 20px 0;">
                        <p style="margin: 0; font-size: 12px;">No check-ins yet</p>
                    </div>
                `;
                return;
            }

            let html = '';
            recentCheckinsData.forEach(checkin => {
                html += `
                    <div class="checkin-item" onclick="showRecentMemberProfile('${JSON.stringify(checkin.data).replace(/'/g, "&apos;")}')">
                        ${checkin.image ? `<img src="${checkin.image}" alt="${checkin.name}" class="checkin-avatar">` : `<div style="width: 32px; height: 32px; border-radius: 50%; background: #f0f0f0;"></div>`}
                        <div class="checkin-details">
                            <p class="checkin-name">${checkin.name}</p>
                            <p class="checkin-time">${checkin.time}</p>
                        </div>
                        <span class="checkin-badge">✓ Present</span>
                    </div>
                `;
            });

            container.innerHTML = html;
        }

        function showRecentMemberProfile(memberDataStr) {
            currentMemberData = JSON.parse(memberDataStr);
            showMemberProfile();
        }

        // Auto-focus input
        document.addEventListener('DOMContentLoaded', function() {
            manualInput.focus();
        });
    </script>
    @endpush

</x-default-layout>
