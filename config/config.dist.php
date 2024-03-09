<?php

/**
 * This software is governed by the CeCILL-B license. If a copy of this license
 * is not distributed with this file, you can obtain one at
 * http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 *
 * Authors of STUdS (initial project): Guilhem BORGHESI (borghesi@unistra.fr) and Raphaël DROZ
 * Authors of Framadate/OpenSondage: Framasoft (https://github.com/framasoft)
 *
 * =============================
 *
 * Ce logiciel est régi par la licence CeCILL-B. Si une copie de cette licence
 * ne se trouve pas avec ce fichier vous pouvez l'obtenir sur
 * http://www.cecill.info/licences/Licence_CeCILL-B_V1-fr.txt
 *
 * Auteurs de STUdS (projet initial) : Guilhem BORGHESI (borghesi@unistra.fr) et Raphaël DROZ
 * Auteurs de Framadate/OpenSondage : Framasoft (https://github.com/framasoft)
 */

return function (Configuration $config) {
    $config->setName('##app-name##');
    $config->setEmail('##app-mail##');
    $config->setResponseAddress('##response-mail##');
    $config->setDatabaseDsn('##db-connection##');
    $config->setDatabaseUser('##db-user##');
    $config->setDatabasePassword('##db-password##');
    $config->setTablePrefix('##db-table-prefix##');
    $config->setMigrationTable('##db-migration-table##');
    $config->setDefaultLanguage('##l18n-default-locale##');
    // $config->setTitleImage('##l18n-default-locale##');
};

