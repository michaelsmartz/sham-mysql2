CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `headcountbydepartment_view` AS
    select 
        `e`.`id` AS `Id`,
        ifnull(`d`.`description`, 'Unspecified') AS `Department`
    from
        (`employees` `e`
        left join `departments` `d` ON ((`d`.`Id` = `e`.`department_id`)))
    where
        ((`e`.`is_active` = 1)
            and isnull(`e`.`date_terminated`));


CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `assetdata_view` AS
    select 
        `ag`.`name` AS `name`, count(`ag`.`id`) AS `total`
    from
        (`assetgroups` `ag`
        join `assets` `a` ON ((`ag`.`id` = `a`.`assetgroup_id`)))
    where
        ((`a`.`is_available` = 1)
            and (`ag`.`is_active` = 1)
            and (`a`.`is_active` = 1))
    group by `ag`.`name`;

CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `newhires_view` AS
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

CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `headcountbygender_view` AS
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
        left join `ethnicgroups` `eg` ON ((`eg`.`Id` = `e`.`ethnicgroup_id`)))
    where
        ((`e`.`is_active` = 1)
            and isnull(`e`.`date_terminated`));

