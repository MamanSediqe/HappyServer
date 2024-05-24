

DROP TABLE IF EXISTS `Links`;

CREATE TABLE `Links` (
  `LinkId` INT NOT NULL,
  `LinkTitle` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LinkValue` VARCHAR(4096) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`LinkId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- For Happy
INSERT INTO `Links` (`LinkId`, `LinkTitle`, `LinkValue`) VALUES 
(1,'Server 01','vless://abd87b55-afaf-4bc6-8dd2-2cce09c4272c@hp.mustang.website:47368?type=kcp&headerType=none&seed=twcK2jV0G4&security=none#Fast-Euro-01'),
(2,'Server 02','vless://c07e8407-319d-4f37-e4be-a60051851111@hp.mustang.website:56425?type=ws&path=%2F&host=&security=none#Bossted-M1'),
(3,'Server 03','ss://MjAyMi1ibGFrZTMtYWVzLTI1Ni1nY206Z0Mza3hKcjZ6UUJNTzBYdm1jRGkrWFFieENpZUNzbHBwcDV0WVNJRXVOYz06YmtuT3NwWEJUUlRocmdJZDhtQWhXY3FTc0tNRXIyYTEydXRSUy9LQ0hRST0@hp.mustang.website:31711?type=tcp#Shadow-Euro-02'),
(4,'Server 97','vmuss://uO1BL.Uf0ui.wY3#9a17h1s82VF0#9a20Q9Vj0Oc0b60#9a3ZjuRmk7mfFhaEcrzfsEfiny.lDc1joXHm#9a4hK0rt0771#9a5MU0al2mh0#9a66BtHJiM6mOMeBy.0ri7ir#9a7phfCcaVqcX3emAb4KotWoYLkEw.1lc6foRvm#9a8PaFf4avBlxrs1Be#9a9Ax2#9aa62HQXipA JepGCl6KeqyaausnBegT FRsE4eVNeil 3XakkdHovFNeWFrtktEyilws6Ce#9abWS1KO4#9acuO6#9adEb4knMPjunPQCbHYsVLntxkHvRcf5dlqzy1wKEhHdBzs0MEMQuhen5Kh4Xr0VpV0XT4wkkqMoF8i2sW5eDEbuSUgbkUJUW1gKSnqWxikQ7xRCCcKvdsDNnUpQhpdkHYI8SFdxwIf5gIEAlUTG3JUUBuJeyrtzI31WC4oDMeaFipQ32I2ZOLgv7jqpNHpJWyHDDWlWT8Ogwzr3Po53blr'),
(5,'Server 98','vmoss://HQhykpBIlg5.RimxKumMsl4tzNaqDnYGgWY.oswrvevVbD6saZiCHt5MeUL/J4hMFasspESpeHy#902tbm8gPC774jYvJnsFpQtlnfgvphyZKNo8vpU3F5ShBHbRMmdwO8Mx0iCEV2D1A0DYXLoPaS6mOlAdO7Dmi4S7fbr0X1EHXaMsFSUNbb8RPh1CcQC8D6KzKJ7ksdQSqnmpykorMs63LcXgma8jZxw6odrDDWC3ve3xiFsr6qaVrM2ml3ZsPSKrXK4s2KPKDbCSGRPrpbU8L2EJpDe4ArGA'),
(6,'Server 99','vmoss://Hchwhpbt.MMmiSugnsjotjHaznn0WgTk.q4wybeVDbPesXyiLjtMRe#902HM1pZsR597oWAcvrmiJT4RBoVOG2ccTNR18Lixe3ady85PRpaJDtSC8hSYTwQi0ofBvjwINb9PljsuJIgVENU');

-- For Phantom
/* 
INSERT INTO `Links` (`LinkId`, `LinkTitle`, `LinkValue`) VALUES 
(1,'Server 01','vless://967bfe19-d857-492b-a0e5-a0924f0731e7@attributes11.zardeshir3.online:9556?type=tcp&path=%2F&headerType=http&security=none#phantom'),
(2,'Server 02','vless://8a0c323d-7a35-4fa9-b139-1b9594c20d09@gr.vitaminmitaminkhooribisabeghevabahal.online:3637?type=ws&path=%2F&host=&security=tls&fp=&alpn=&sni=gr.vitaminmitaminkhooribisabeghevabahal.online#FastServer2'),
(3,'Server 03','vless://8ef6ef28-52cb-4892-8d2a-4a87da1f7681@5.78.98.59:1858?type=ws&path=%2F&host=&security=none#FastServer'),
(4,'Server 97','vmuss://Xr1HU.oM0S8.kz3#9a1N01AE2110#9a2vI9tn0Ai0aE0#9a3MWuPWkAJfeEa2irVEswfiEO.v3cikoYNm#9a4NB0PR0ZL1#9a5Cd06b2YR0#9a61mtfEiIdmAaeLz.4eikQr#9a737fp4aMzcTveTjbBJoMwodPkdG.AwcYfoaMm#9a82bFVGaxHlS6s3ae#9a91Z2#9aaY4HsEiVY 4gpIplWDeIRapasdBeGM Eks2KesZeXK brawCdC7vUeeoFr5LtF2iuHsA7e#9ab2a1NH0#9acBp4#9adfGaMSYiI8el6jEtGVIVyveobXTS0D8V434dx3NXbrfQgjENVKeG0Y8Punk5Jw1D5z2XAXoszpAuxaw4qgBT8qNRVEHGbRySkyw8Xocty54RSHwqF3Os0jYBheoIKR27RXJ5GZ8oAEyuxoChCQXgVhYgefIKWnWteeLzLADFSFG8ng1XqLbYDvRQ3CdNkM7A3dPtDi8OfTvcbkKPTf6tI'),
(5,'Server 98','vmoss://PodeOoUewG4h5oiXZlNgeGlfSPoISr87.XBo4onLglQmiGYn9de99Fi8GlVVbABg6WB3J5LoQlosQdRJU5369ga3mxavFphWE4vDmECVsHJImfEJGmIV3kMaRnbeNw45vmxzVEhNxlUxTf'),
(6,'Server 99','vmoss://8DpogejSrqueLDpA4emjrBL.Iici5lLboh6u6Fd99neiJIaa45pMNlBBrIV3G1cbgpmnb9Dr1oPwgiDHJvgKaxf4JoNfYIvpjE3DSkV00AqZIvDVCivUO8SHxhZWMqAyoTcP0SAXyY2J2V'),
(7,'Server 100','vmoss://uVuFFlDdsJMtczedgrFxfcMr70yWM.9SscaitJtc8e99KaWM0bINsCY9KIhvWn0N9WIyhJXq81Ua1aQnAL7bmc7ShehHa8utXHIVtyL1uo2punCyAJ01E7MQa60lqKq6pcOkD5DUf6OKZn'),
(8,'Server 101','vmoss://qF4jg0xSsHhau4lc3ebYys0eitkutaUnbvtoB2oevsJZnKyeukmMsic0zzEa5zrRNe4xbNje2Ekt6hF0aNcby8iFBmTc.Pcs4JitatMpe99b56nWEjgPbpk9dXtOSODzl9sDCjS8pHnNba'),
(9,'Server 102','vmoss://xevu9iBAtvSaF0mmSiA7nIHmVAiJltJJayNmYniaEnSvkPyh2YoJqoiSrnOixTbwbiJOsnLapYbqHepigVfhy1e0DvwBa6EbEAaEYhBlaQnlY7.fVovTnFVliviePnNqe99PzGtDoexbBU'),
(10,'Server 103','vmoss://1IuWskZRf2waLRrYXsWOiYQ.J7cX7ocvm99QNHyGyBaPqphuaDjTMH6dq09jNutCzcNlbUTbuLYqyuYTbwXWaFeVTKcSbemWeah3LE2zWK1Rm6tZEf77rgqAAFA51G5KH3aoXStyIHyNVb');
 */
DROP TABLE IF EXISTS `UsersLog`;

CREATE TABLE `UsersLog` (
  `LogId` INT NOT NULL AUTO_INCREMENT,
  `LogTime` DATETIME NOT NULL,
  `UserIP` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DeviceId` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `AppVersion` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `RefUrl` VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Location` VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`LogId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `UsersLog` (`LogTime`, `UserIP`, `DeviceId`, `AppVersion`, `RefUrl`) 
VALUES (NOW(), 'Sample', '11111', '0.0.0', '/happy/list.php');

