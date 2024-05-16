

DROP TABLE IF EXISTS `Links`;

CREATE TABLE `Links` (
  `LinkId` INT NOT NULL,
  `LinkTitle` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LinkValue` VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`LinkId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `Links` (`LinkId`, `LinkTitle`, `LinkValue`) VALUES 
(1,'Server 01','vless://abd87b55-afaf-4bc6-8dd2-2cce09c4272c@hp.mustang.website:47368?type=kcp&headerType=none&seed=twcK2jV0G4&security=none#Fast-Euro-01'),
(2,'Server 02','vless://c07e8407-319d-4f37-e4be-a60051851111@hp.mustang.website:56425?type=ws&path=%2F&host=&security=none#Bossted-M1'),
(3,'Server 03','ss://MjAyMi1ibGFrZTMtYWVzLTI1Ni1nY206Z0Mza3hKcjZ6UUJNTzBYdm1jRGkrWFFieENpZUNzbHBwcDV0WVNJRXVOYz06YmtuT3NwWEJUUlRocmdJZDhtQWhXY3FTc0tNRXIyYTEydXRSUy9LQ0hRST0@hp.mustang.website:31711?type=tcp#Shadow-Euro-02'),
(4,'Server 97','vmuss://uO1BL.Uf0ui.wY3#9a17h1s82VF0#9a20Q9Vj0Oc0b60#9a3ZjuRmk7mfFhaEcrzfsEfiny.lDc1joXHm#9a4hK0rt0771#9a5MU0al2mh0#9a66BtHJiM6mOMeBy.0ri7ir#9a7phfCcaVqcX3emAb4KotWoYLkEw.1lc6foRvm#9a8PaFf4avBlxrs1Be#9a9Ax2#9aa62HQXipA JepGCl6KeqyaausnBegT FRsE4eVNeil 3XakkdHovFNeWFrtktEyilws6Ce#9abWS1KO4#9acuO6#9adEb4knMPjunPQCbHYsVLntxkHvRcf5dlqzy1wKEhHdBzs0MEMQuhen5Kh4Xr0VpV0XT4wkkqMoF8i2sW5eDEbuSUgbkUJUW1gKSnqWxikQ7xRCCcKvdsDNnUpQhpdkHYI8SFdxwIf5gIEAlUTG3JUUBuJeyrtzI31WC4oDMeaFipQ32I2ZOLgv7jqpNHpJWyHDDWlWT8Ogwzr3Po53blr'),
(5,'Server 98','vmoss://HQhykpBIlg5.RimxKumMsl4tzNaqDnYGgWY.oswrvevVbD6saZiCHt5MeUL/J4hMFasspESpeHy#902tbm8gPC774jYvJnsFpQtlnfgvphyZKNo8vpU3F5ShBHbRMmdwO8Mx0iCEV2D1A0DYXLoPaS6mOlAdO7Dmi4S7fbr0X1EHXaMsFSUNbb8RPh1CcQC8D6KzKJ7ksdQSqnmpykorMs63LcXgma8jZxw6odrDDWC3ve3xiFsr6qaVrM2ml3ZsPSKrXK4s2KPKDbCSGRPrpbU8L2EJpDe4ArGA'),
(6,'Server 99','vmoss://Hchwhpbt.MMmiSugnsjotjHaznn0WgTk.q4wybeVDbPesXyiLjtMRe#902HM1pZsR597oWAcvrmiJT4RBoVOG2ccTNR18Lixe3ady85PRpaJDtSC8hSYTwQi0ofBvjwINb9PljsuJIgVENU');


DROP TABLE IF EXISTS `UsersLog`;

CREATE TABLE `UsersLog` (
  `LogId` INT NOT NULL AUTO_INCREMENT,
  `LogTime` DATETIME NOT NULL,
  `UserIP` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DeviceId` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AppVersion` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefUrl` VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `UsersLog` (`LogTime`, `UserIP`, `DeviceId`, `AppVersion`, `RefUrl`) 
VALUES (NOW(), 'Sample', '11111', '0.0.0', '/happy/list.php');

