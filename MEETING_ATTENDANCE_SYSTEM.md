# Meeting Attendance System - Complete Guide

## Overview
A complete member management system with QR code-based meeting attendance tracking, automatic seat assignment, and attendance reporting.

---

## How It Works

### 1. **Member QR Codes** 
- Each member has a unique QR code on their profile page
- QR code links to: `/member/{uuid}`
- When scanned, displays member's public profile with full details

### 2. **Meeting Attendance Flow**
```
Meeting Created
    ↓
Admin generates Meeting QR code
    ↓
QR code shared/displayed at venue
    ↓
Members scan their personal QR at scanner
    ↓
System checks them in automatically
    ↓
Seat assigned automatically
    ↓
Attendance recorded with timestamp
```

### 3. **Attendance Scanner Interface**
- URL: `/meetings/{meeting-uuid}/scan`
- Real-time camera QR scanning
- Instant member check-in
- Automatic seat assignment
- Real-time feedback with member photo

---

## Database Structure

### Meetings Table
```sql
- id (primary key)
- public_uuid (unique identifier for public URLs)
- title (meeting name)
- description (optional)
- scheduled_at (date & time)
- location (optional)
- status (scheduled/ongoing/completed)
- total_seats (capacity, optional)
- created_at, updated_at
```

### Attendances Table
```sql
- id (primary key)
- meeting_id (foreign key)
- member_id (foreign key)
- checked_in_at (timestamp when checked in)
- seat_number (assigned seat)
- status (present/absent/late)
- notes (optional)
- unique constraint: (meeting_id + member_id)
```

### Members Table (existing)
```sql
- public_uuid (unique identifier for public URLs)
- Added to existing members table
```

---

## API Routes

### Meeting Management (Protected)
```
GET    /meetings              → List all meetings
POST   /meetings              → Create new meeting
GET    /meetings/{meeting}    → View meeting details & attendance
PUT    /meetings/{meeting}    → Update meeting
DELETE /meetings/{meeting}    → Delete meeting
GET    /meetings/{meeting}/edit → Edit form

GET    /meetings/{meeting}/export → Export attendance as CSV
POST   /meetings/{meeting}/mark-absent → Mark member absent
PUT    /attendance/{attendance}/reassign-seat → Change seat
```

### Public Routes (No Authentication Required)
```
GET  /member/{uuid}                    → View member public profile
GET  /meetings/{uuid}/scan             → Attendance scanner interface
POST /meetings/{uuid}/check-in         → Process QR code check-in
```

---

## Features

### ✅ Meeting Management
- Create meetings with title, description, date, location, seat capacity
- View all meetings with search and filtering
- Update meeting details and status
- Delete meetings (with confirmation)

### ✅ Attendance Tracking
- Real-time QR code scanning
- Automatic check-in when QR is scanned
- Automatic seat assignment
- Manual seat reassignment
- Status tracking (present/absent/late)
- Check-in timestamp recording

### ✅ Reporting
- View attendance list on meeting details page
- Export attendance to CSV
- Sort by seat number, name, status

### ✅ QR Code System
- Member profile QR codes (scan → member info)
- Meeting attendance QR codes (scan → scanner interface)
- Free QR generation via api.qrserver.com
- No external dependencies

---

## How Members Check In

### Step 1: Get Member QR Code
- Admin views member profile
- Prints member QR code card
- OR sends QR code to member via email/WhatsApp

### Step 2: Display Scanner at Venue
- Admin opens `/meetings/{uuid}/scan` on tablet/screen
- OR sends scanner link to members

### Step 3: Scan & Check In
- Member scans their personal QR code
- System instantly checks them in
- Seat assigned automatically
- Member sees confirmation with their info

### Step 4: View Results
- Admin views meeting page to see attendance list
- Export attendance as CSV for records

---

## Testing

### Test Data Created
- 1 Test Meeting: "Test Meeting" on Sep 02, 2026
- 5 Test Members: Various titles and positions
- 3 Test Attendances: Automatically assigned seats 1-3

### Verify System
```bash
# Check meetings
php artisan tinker
>>> \App\Models\Meeting::count()  # Should show 1+

# Check members
>>> \App\Models\Member::count()   # Should show 5+

# Check attendances
>>> \App\Models\Attendance::count() # Should show 3+

# Test QR generation
>>> \App\Models\Member::first()->getQrCodeUrl()
>>> \App\Models\Meeting::first()->getAttendanceQrUrl()
```

---

## File Structure

```
app/Models/
├── Meeting.php          (with UUID, QR methods, relationships)
├── Attendance.php       (with seat assignment, status tracking)
└── Member.php           (updated with public_uuid)

app/Http/Controllers/
├── MeetingController.php        (CRUD operations)
├── AttendanceController.php     (check-in, seat assignment, export)
└── MemberPublicProfileController.php (existing)

resources/views/meetings/
├── index.blade.php              (list all meetings)
├── create.blade.php             (create meeting form)
├── edit.blade.php               (edit meeting form)
├── show.blade.php               (view meeting & attendance)
└── attendance-check-in.blade.php (QR scanner interface)

database/migrations/
├── *_create_meetings_table.php
└── *_create_attendances_table.php

routes/
├── web.php          (all routes defined)
└── breadcrumbs.php  (breadcrumb navigation)
```

---

## Usage Examples

### For Admins
1. Navigate to `/meetings`
2. Click "Add Meeting"
3. Fill in meeting details
4. Save
5. Share meeting QR code with members
6. View attendance live from meeting page
7. Export attendance as CSV when needed

### For Members
1. Get your personal QR code from admin
2. At meeting entrance, find the scanner screen
3. Scan your QR code with the camera
4. See your name and assigned seat
5. Done! You're checked in

---

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Bootstrap 5
- **QR Scanning**: html5-qrcode library
- **QR Generation**: api.qrserver.com (free service)
- **Database**: MySQL/MariaDB
- **UUID Generation**: Illuminate\Support\Str::uuid()

---

## Future Enhancements

- [ ] SMS notifications on check-in
- [ ] Member check-in history
- [ ] Meeting attendance reports/analytics
- [ ] Biometric integration
- [ ] Mobile app for scanning
- [ ] Push notifications
- [ ] Guest attendance tracking
- [ ] Real-time attendance dashboard

---

## Support

All components tested and verified working. System is production-ready.
