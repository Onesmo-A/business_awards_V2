# Admin Applications Table Improvements - TODO

## Status: In Progress ✅

### Step 1: Create TODO.md [COMPLETED]
- [x] Generated this file with all steps

### Step 2: Update Vue Index.vue (Truncation + Export Button) [COMPLETED]
- [x] Add Tailwind truncate classes to table cells (max-w-[150px], truncate, overflow-hidden)
- [x] Add hover title for full text
- [x] Add \"Export Photos ZIP\" button next to PDF export

### Step 3: Update Vue Show.vue (Bio Truncation) [COMPLETED]\n- [x] Truncate bio preview to 200 chars + \"...\" + expand toggle for full view

### Step 4: Add Route for Photo Export [COMPLETED]\n- [x] Add GET route in routes/web.php: admin.applications.export.photos

### Step 5: Implement Controller exportPhotos() Method [COMPLETED]\n- [x] New method in AdminNomineeApplicationController: Filter apps with photos, create ZIP with renamed originals (e.g. \"{name}_{id}.jpg\"), download

### Step 6: Update Resource (Optional Perf) [COMPLETED]\n- [x] Truncate bio in NomineeApplicationResource.php

### Step 7: Reliability Enhancements
- [x] Add perf query selects/limit
- [x] New migration for indexes (status, reviewed_at) [Skipped - optional for now]

### Step 8: Test & Complete
- [x] Clear caches: php artisan optimize:clear
- [x] Test table truncation, photo ZIP export (quality/original, renamed)\n- [x] Attempt completion

*Next Action: Step 4 - Add route in web.php*

