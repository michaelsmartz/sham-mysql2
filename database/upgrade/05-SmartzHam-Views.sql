#--------Views
CREATE  OR REPLACE VIEW `HeadCountByDepartment_view` AS
    SELECT  e.id As Id,
            IFNULL(d.description, 'Unspecified') AS Department
    FROM    Employees e
            LEFT OUTER JOIN departments d ON d.id = e.department_id
    WHERE   e.is_active = 1
            AND e.date_terminated IS NULL;
			
#--------Views
CREATE  OR REPLACE  VIEW `headcountbygender_view` AS
    SELECT 
        `e`.`id` AS `Id`,
        IFNULL(`g`.`description`, 'Unspecified') AS `Sex`,
        IFNULL(`eg`.`description`, 'Unspecified') AS `Ethnicity`,
        `e`.`date_terminated` AS `TerminationDate`,
        `e`.`date_joined` AS `JoinedDate`,
        (CASE
            WHEN
                (`e`.`date_joined` IS NOT NULL)
            THEN
                TIMESTAMPDIFF(YEAR,
                    `e`.`date_joined`,
                    CURDATE())
            ELSE 0
        END) AS `YearsService`,
        1 AS `size`
    FROM
        ((`employees` `e`
        LEFT JOIN `genders` `g` ON ((`g`.`id` = `e`.`gender_id`)))
        LEFT JOIN `ethnic_groups` `eg` ON ((`eg`.`Id` = `e`.`ethnic_group_id`)))
    WHERE
        ((`e`.`is_active` = 1)
            AND ISNULL(`e`.`date_terminated`));
			
#--------Views
CREATE OR REPLACE VIEW `newhires_view` AS
    select 
        year(`employees`.`date_joined`) AS `Year`,
        count(`employees`.`id`) AS `Count`,
        0 AS `Type`,
		'Hired' as `Name`
    from
        `employees`
    where
        ((`employees`.`date_joined` is not null)
            and (`employees`.`date_joined` >= (now() - interval 5 year)))
    group by year(`employees`.`date_joined`) 
    union select 
        year(`employees`.`date_terminated`) AS `Year`,
        count(`employees`.`id`) AS `Count`,
        1 AS `Type`,
		'Terminated' as `Name`
    from
        `employees`
    where
        ((`employees`.`date_terminated` is not null)
            and (`employees`.`date_terminated` >= (now() - interval 5 year)))
    group by year(`employees`.`date_terminated`); 
	
#------Views

CREATE OR REPLACE VIEW `headcountbygender_view` AS
    select 
        `e`.`id` AS `Id`,
        ifnull(`g`.`description`, 'Unspecified') AS `Sex`,
        ifnull(`eg`.`Description`, 'Unspecified') AS `Ethnicity`,
        `e`.`date_terminated` AS `TerminationDate`,
        `e`.`date_joined` AS `JoinedDate`,
        (case
            when
                (`e`.`date_joined` is not null)
            then
                timestampdiff(YEAR,
                    `e`.`date_joined`,
                    curdate())
            else 0
        end) AS `YearsService`,
		1 AS `Size`
    from
        ((`employees` `e`
        left join `genders` `g` ON ((`g`.`id` = `e`.`gender_id`)))
        left join `ethnic_groups` `eg` ON ((`eg`.`Id` = `e`.`ethnic_group_id`)))
    where
        ((`e`.`is_active` = 1)
            and isnull(`e`.`date_terminated`));
            
#--01-Views ---------------------------------------------------------------------------------------
CREATE  OR REPLACE VIEW `QAEvaluationsView`
as
	select ev.assessment_id, sum(points) as TotalPoints, ev.feedback_date as Feedbackdate,T.total_threshold as TotalThreshold,pc.description  from evaluations ev
       inner join evaluation_results er
       on ev.id = er.evaluation_id and ev.createdbyemployee_id = er.assessoremployee_id
       inner join (
              SELECT aac.assessment_id as assessmentid, sum(threshold) as total_threshold from assessments_assessment_category aac inner join assessment_categories ac
              on aac.assessmentcategory_id = ac.id where aac.is_active = 1
               group by aac.assessment_id
       ) T
       on T.assessmentid = ev.assessment_id
       inner join product_categories pc
       on ev.productcategory_id = pc.id
       where ev.is_active = 1 and er.is_active = 1
       group by ev.id,ev.assessment_id,ev.feedback_date,T.total_threshold,pc.description;
	   

#--02-Views --------------------------------------------------------------------------------------- 	   
CREATE OR REPLACE VIEW `QAEvaluationScoresView`
as 
select data.evaluation_id AS EvaluationId,data.assessment_id AS AssessmentId,data.assessoremployee_id AS AssessorEmployeeId,data.feedback_date AS Feedbackdate,data.points AS Points,round(cast(data.points as decimal(10,3))/cast(at.total_threshold as decimal(10,3))) as Percentage
from 
(
select evaluation_id,assessoremployee_id,sum(points) as Points,er.assessment_id,e.feedback_date from evaluation_results er
inner join evaluations e on e.id = er.evaluation_id
where er.is_active = 1 and e.feedback_date between DATE_ADD(current_timestamp,Interval -370 DAY) and current_timestamp
group by evaluation_id,assessoremployee_id,er.assessment_id,e.feedback_date

) data
inner join 
(
select t.assessment_id,sum(t.threshold) as total_threshold from 
(
select aac.assessment_id, aac.assessmentcategory_id, ac.threshold from assessments_assessment_category aac 
inner join assessment_categories ac on ac.id = aac.assessmentcategory_id
where aac.is_active = 1 and aac.assessment_id in (

select distinct(er.assessment_id) from evaluation_results er
inner join evaluations e on e.id = er.evaluation_id
where er.is_active = 1 and e.feedback_date between DATE_ADD(current_timestamp,Interval -370 DAY) and current_timestamp
group by evaluation_id,assessoremployee_id,er.assessment_id,e.feedback_date

)
group by aac.assessment_id,aac.assessmentcategory_id,ac.threshold
) t
group by t.assessment_id
) at
on data.assessment_id = at.assessment_id;
	
#--02-Views --------------------------------------------------------------------------------------- 	   
CREATE 
OR REPLACE ALGORITHM = UNDEFINED 
DEFINER = `root`@`localhost` 
SQL SECURITY DEFINER
VIEW `assetdata_view` AS
select 
`ag`.`name` AS `name`, count(`ag`.`id`) AS `total`
from
(`asset_groups` `ag`
join `assets` `a` ON ((`ag`.`id` = `a`.`asset_group_id`)))
where
((`a`.`is_available` = 1)
and (`ag`.`deleted_at` is null)
and (`a`.`deleted_at` is null))
group by `ag`.`name`;