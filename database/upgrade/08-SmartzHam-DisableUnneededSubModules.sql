UPDATE system_modules SET is_active=0 WHERE id IN (4,6,7,9,10);
UPDATE system_modules SET is_active=0 WHERE id IN (13);

UPDATE system_sub_modules SET is_active=0 WHERE id IN (2,3,4,12,13,18,19);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (23,24,25,26,27,28,29);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (34,35,37,38,39);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (40,44,46,47,48,49);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (50,51,52,53,54,56,57,58);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (61,62,63,65,66,67,68,69);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (72,76);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (81);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (91,95,97,99,100);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (107,108,109,110);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (112,113,114);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (116,117);
UPDATE system_sub_modules SET is_active=0 WHERE id IN (121,123,124,125,126);

#--UPDATE `system_modules` SET `deleted_at`= now() WHERE `is_active` = 0;
#--UPDATE `system_sub_modules` SET `deleted_at`= now() WHERE `is_active` = 0;

UPDATE `system_modules` SET `deleted_at`= now() WHERE id in (4,6,7,9,10,13);

UPDATE `system_sub_modules` SET `deleted_at`= now()  where id in
(2,3,4,12,13,18,19,23,24,25,26,27,28,29,34,35,37,38,39,40,44,46,47,48,49,50,51,52,53,54,56,57,58,61,62,63,65,66,67,68,69,72,76,81,91,95,97,99,100,107,108,109,110,112,113,114,116,117,121,122,123,124,125,126);