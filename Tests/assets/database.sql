CREATE TABLE `bets` (
    `id` INT UNSIGNED NOT NULL,
    `value` INT UNSIGNED NOT NULL,
    `winner` TINYINT NOT NULL DEFAULT '0',
    `multiplier` FLOAT NOT NULL,
    PRIMARY KEY (`id`)
);