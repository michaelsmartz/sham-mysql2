UPDATE system_sub_modules SET is_active=0 WHERE id IN (2,3,12,13);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (25,28,29);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (35,37,38,39);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (40,44,46,47,48,49);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (50,51,53,54,56,57,58);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (61,62,63,65,66,67,68,69);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (108,109,110);

UPDATE `system_sub_modules` SET `deleted_at`= now() WHERE `is_active` = 0;