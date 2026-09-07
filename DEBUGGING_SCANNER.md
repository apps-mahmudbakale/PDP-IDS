# Scanner Debugging Guide

## 🔍 Issue: UUID Scan/Paste Goes Nowhere

If scanning or pasting a UUID doesn't produce results, follow these steps:

### Step 1: Check Browser Console
1. Open your browser's Developer Tools (F12 or Cmd+Option+I)
2. Go to the **Console** tab
3. Paste or scan a UUID
4. Look for console messages that should appear:
   - `Checking in member: [uuid]`
   - `Meeting UUID: [uuid]`
   - `API URL: /meetings/[uuid]/check-in`
   - `Response status: [number]`
   - `Success response: {...}`

### Step 2: Verify Meeting UUID
The scanner page URL should be:
```
/meetings/{MEETING_UUID}/scan
```

Example:
```
/meetings/1046d030-737b-4fdb-be3e-4f47918e06e2/scan
```

**Check:**
- ✓ Is the URL showing a valid UUID?
- ✓ Copy the UUID from the URL
- ✓ Try pasting that UUID into the console to verify format

### Step 3: Test Member UUID
Try pasting one of these test UUIDs:
```
959d1c08-99b1-4102-9575-079c043a6948  (Test1 Member1)
5b361f42-24f1-47f6-ae66-6bb168697cd9  (Test2 Member2)
aee99c87-67a7-4e60-9020-468053dc3c22  (Test3 Member3)
```

**Steps:**
1. Click the input field
2. Paste the UUID
3. Press Enter
4. Check console for response

### Step 4: Check Network Tab
1. Go to **Network** tab in Developer Tools
2. Paste a UUID or scan
3. Look for a POST request to `/meetings/.../check-in`
4. Click on it to see:
   - **Headers** - CSRF token, Content-Type
   - **Request Payload** - The UUID being sent
   - **Response** - The JSON response from server

**Expected Response:**
```json
{
  "success": true,
  "message": "Test1 Member1 checked in successfully!",
  "member": {
    "name": "Test1 Member1",
    "position": "Position 1",
    "seat": 1,
    "image": null
  },
  "meeting_attendance": 3
}
```

### Step 5: Check Result Card Display
If the API returns success but result card doesn't show:

1. Press F12 to open Developer Tools
2. Go to **Console**
3. Type and run:
```javascript
document.getElementById('resultCard').classList.add('show');
```

4. See if the result card appears
5. If it does, the issue is with the `showResult()` function
6. If it doesn't, the CSS or element might be hidden

### Step 6: Verify Element Exists
In the **Console**, run:
```javascript
console.log('Result card:', document.getElementById('resultCard'));
console.log('Result title:', document.getElementById('resultTitle'));
console.log('Manual input:', document.getElementById('manualInput'));
```

All three should return the element (not null).

---

## 📊 Common Issues & Solutions

### Issue 1: "Checking in member" appears but nothing happens

**Cause:** API not responding

**Fix:**
1. Check Network tab for failed requests
2. Verify meeting UUID is correct
3. Check if member exists with that UUID
4. Look for error response (404, 500, etc.)

**Test:**
```bash
# In Laravel Tinker
php artisan tinker
$member = \App\Models\Member::where('public_uuid', '[paste-uuid]')->first();
$member ? 'Found' : 'Not found';
```

### Issue 2: Network request shows 404

**Cause:** Wrong URL or route not found

**Fix:**
1. Check meeting UUID in scanner URL
2. Verify route exists: `php artisan route:list | grep check-in`
3. Ensure meeting exists: `php artisan tinker`

```
\App\Models\Meeting::where('public_uuid', '[uuid]')->first();
```

### Issue 3: Response status 422 (Validation Error)

**Cause:** Missing or invalid UUID in request

**Fix:**
1. Check the member_uuid value in Network tab
2. Ensure UUID format is correct (8-4-4-4-12 hex)
3. Verify CSRF token is present in headers

### Issue 4: Result card shows but is empty

**Cause:** JavaScript error in `showResult()`

**Fix:**
1. Check Console for JavaScript errors
2. Verify element IDs match: `resultCard`, `resultTitle`, `resultSubtitle`, `memberCard`
3. Check if member data has required fields

**Debug in Console:**
```javascript
var data = {
  success: true,
  member: { name: 'Test', position: 'Dev', seat: 1, image: null },
  meeting_attendance: 3
};
showResult(data);
```

---

## 🔧 Manual API Test

### Using cURL or Postman

**Endpoint:**
```
POST /meetings/{meeting_uuid}/check-in
```

**Headers:**
```
Content-Type: application/json
X-CSRF-TOKEN: {csrf_token}
```

**Body:**
```json
{
  "member_uuid": "959d1c08-99b1-4102-9575-079c043a6948"
}
```

**Example cURL:**
```bash
curl -X POST \
  http://localhost:8000/meetings/1046d030-737b-4fdb-be3e-4f47918e06e2/check-in \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: $(csrf_token)" \
  -d '{
    "member_uuid": "959d1c08-99b1-4102-9575-079c043a6948"
  }'
```

---

## 📱 Browser Console Debugging

### View Console Messages

Add this to see what's happening:

```javascript
// Check if elements exist
console.table({
  'resultCard': !!document.getElementById('resultCard'),
  'resultTitle': !!document.getElementById('resultTitle'),
  'memberCard': !!document.getElementById('memberCard'),
  'cameraTrigger': !!document.getElementById('cameraTrigger'),
  'manualInput': !!document.getElementById('manualInput')
});

// Check CSRF token
console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);

// Check camera status
console.log('Camera paused:', isScanningPaused);
console.log('Last scanned:', lastScannedUuid);
```

### Test Check-in Manually

```javascript
// Manually test check-in with a known UUID
checkInMember('959d1c08-99b1-4102-9575-079c043a6948');
```

Then check console for:
- `Checking in member: 959d1c08-99b1-4102-9575-079c043a6948`
- `Response status: 200`
- `Success response: {...}`

---

## ✅ Expected Flow

1. **Page Loads**
   - Console: `🚀 Scanner page loaded`
   - Console: `✓ QR Scanner initialized`
   - Camera status shows `🔴 Camera Active - Scanning...`

2. **Scan/Paste UUID**
   - Console: `Checking in member: [uuid]`
   - Console: `Meeting UUID: [uuid]`
   - Network: POST request appears

3. **Server Responds**
   - Console: `Response status: 200`
   - Console: `Success response: {...}`
   - Live counter updates
   - Result card appears

4. **Result Card Shows**
   - Member name displays
   - Position displays
   - Seat displays
   - Green success banner

---

## 🆘 Still Not Working?

1. **Clear cache:** Cmd+Shift+R (Mac) or Ctrl+Shift+R (Windows)
2. **Check server logs:** `tail -f storage/logs/laravel.log`
3. **Verify database:** Check if members and meetings exist
4. **Restart server:** `php artisan serve`
5. **Check CSRF token:** Is it being sent in headers?

---

## 📞 Quick Checklist

- ✅ Browser console open (F12)
- ✅ Network tab visible to see requests
- ✅ Valid meeting UUID in scanner URL
- ✅ Valid member UUID to scan/paste
- ✅ Camera permission granted (if using camera)
- ✅ Server running (`php artisan serve`)
- ✅ Database populated with test data
- ✅ No JavaScript errors in console

Once you've checked these, scanning should work! 🚀
