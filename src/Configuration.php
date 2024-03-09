<?php

class Configuration
{
    private string $name = '';

    private string $email = 'app@application.local';

    private string $responseAddress = 'no-replay@application.local';

    private string $databaseDsn = '';

    private string $databaseUser = '';

    private string $databasePassword = '';

    private string $tablePrefix = '';

    private string $migrationTable = '';

    private string $defaultLanguage = '';

    private string $titleImage = 'images/logo-framadate.png';

    private string $logFile = 'admin/stdout.log';

    private int $purgeDelay = 60;

    private int $maxSlotsPerPoll = 366;

    // Number of seconds before we allow to resend an "Remember Edit Link" email.
    private int $timeEditLinkEmail = 60;

    private bool $useSmtp = true;

    private string $smtpDsn = 'smtp://localhost';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getResponseAddress(): string
    {
        return $this->responseAddress;
    }

    /**
     * @param string $responseAddress
     */
    public function setResponseAddress(string $responseAddress): void
    {
        $this->responseAddress = $responseAddress;
    }

    /**
     * @return string
     */
    public function getDatabaseDsn(): string
    {
        return $this->databaseDsn;
    }

    /**
     * @param string $databaseDsn
     */
    public function setDatabaseDsn(string $databaseDsn): void
    {
        $this->databaseDsn = $databaseDsn;
    }

    /**
     * @return string
     */
    public function getDatabaseUser(): string
    {
        return $this->databaseUser;
    }

    /**
     * @param string $databaseUser
     */
    public function setDatabaseUser(string $databaseUser): void
    {
        $this->databaseUser = $databaseUser;
    }

    /**
     * @return string
     */
    public function getDatabasePassword(): string
    {
        return $this->databasePassword;
    }

    /**
     * @param string $databasePassword
     */
    public function setDatabasePassword(string $databasePassword): void
    {
        $this->databasePassword = $databasePassword;
    }

    /**
     * @return string
     */
    public function getTablePrefix(): string
    {
        return $this->tablePrefix;
    }

    /**
     * @param string $tablePrefix
     */
    public function setTablePrefix(string $tablePrefix): void
    {
        $this->tablePrefix = $tablePrefix;
    }

    /**
     * @return string
     */
    public function getMigrationTable(): string
    {
        return $this->migrationTable;
    }

    /**
     * @param string $migrationTable
     */
    public function setMigrationTable(string $migrationTable): void
    {
        $this->migrationTable = $migrationTable;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * @param string $defaultLanguage
     */
    public function setDefaultLanguage(string $defaultLanguage): void
    {
        $this->defaultLanguage = $defaultLanguage;
    }

    /**
     * @return string
     */
    public function getTitleImage(): string
    {
        return $this->titleImage;
    }

    /**
     * @param string $titleImage
     */
    public function setTitleImage(string $titleImage): void
    {
        $this->titleImage = $titleImage;
    }

    /**
     * @return string
     */
    public function getLogFile(): string
    {
        return $this->logFile;
    }

    /**
     * @param string $logFile
     */
    public function setLogFile(string $logFile): void
    {
        $this->logFile = $logFile;
    }

    /**
     * @return int
     */
    public function getPurgeDelay(): int
    {
        return $this->purgeDelay;
    }

    /**
     * @param int $purgeDelay
     */
    public function setPurgeDelay(int $purgeDelay): void
    {
        $this->purgeDelay = $purgeDelay;
    }

    /**
     * @return int
     */
    public function getMaxSlotsPerPoll(): int
    {
        return $this->maxSlotsPerPoll;
    }

    /**
     * @param int $maxSlotsPerPoll
     */
    public function setMaxSlotsPerPoll(int $maxSlotsPerPoll): void
    {
        $this->maxSlotsPerPoll = $maxSlotsPerPoll;
    }

    /**
     * @return int
     */
    public function getTimeEditLinkEmail(): int
    {
        return $this->timeEditLinkEmail;
    }

    /**
     * @param int $timeEditLinkEmail
     */
    public function setTimeEditLinkEmail(int $timeEditLinkEmail): void
    {
        $this->timeEditLinkEmail = $timeEditLinkEmail;
    }

    /**
     * @return bool
     */
    public function isUseSmtp(): bool
    {
        return $this->useSmtp;
    }

    /**
     * @param bool $useSmtp
     */
    public function setUseSmtp(bool $useSmtp): void
    {
        $this->useSmtp = $useSmtp;
    }

    /**
     * @return string
     */
    public function getSmtpDsn(): string
    {
        return $this->smtpDsn;
    }

    /**
     * @param string $smtpDsn
     */
    public function setSmtpDsn(string $smtpDsn): void
    {
        $this->smtpDsn = $smtpDsn;
    }

    /* home */
//    'show_what_is_that' => true,            // display "how to use" section
//    'show_the_software' => true,            // display technical information about the software
//    'show_cultivate_your_garden' => true,   // display "development and administration" information
    /* create_classic_poll.php / create_date_poll.php */
//    'default_poll_duration' => 180,         // default values for the new poll duration (number of days).
    /* create_classic_poll.php */
//    'user_can_add_img_or_link' => true,     // user can add link or URL when creating his poll.
//    'markdown_editor_by_default' => true,   // The markdown editor for the description is enabled by default
//    'provide_fork_awesome' => true,         // Whether the build-in fork-awesome should be provided


}
