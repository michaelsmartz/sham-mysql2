UPDATE `timelines` SET `eventable_type`='App\\HistoryJobTitle' WHERE  `timeline_event_type_id`=1;
UPDATE `timelines` SET `eventable_type`='App\\HistoryDepartment' WHERE  `timeline_event_type_id`=2;
UPDATE `timelines` SET `eventable_type`='App\\HistoryDisciplinaryAction' WHERE  `timeline_event_type_id`=3;
UPDATE `timelines` SET `eventable_type`='App\\HistoryReward' WHERE  `timeline_event_type_id`=4;