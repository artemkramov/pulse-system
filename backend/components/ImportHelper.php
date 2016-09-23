<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 3/22/16
 * Time: 5:37 PM
 */

namespace backend\components;

use backend\models\BbUsers;
use backend\models\UploadForm;
use yii\db\Query;
use yii2mod\ftp\FtpClient;


class ImportHelper
{

    function __construct()
    {
        $this->localPath = \Yii::getAlias("@backend") . "/uploads/";
    }

    private $host = "127.0.0.1";
    private $username = "akramov";
    private $password = "10051994aK";
    private $localPath = "";

    /**
     * @throws \yii2mod\ftp\FtpException
     */
    function uploadRemoteFiles()
    {
        $ftp = new FtpClient();
        $ftp->connect($this->host);
        $ftp->login($this->username, $this->password);
        $ftp->chdir("files");
        $dir_list = $ftp->nlist();
        $mostRecent = array(
            'time' => 0,
            'file' => null
        );
        $neededFiles = ['BB_Main.mdb'];
        $pattern = "/^BB_Log.*\\.mdb$/";
        $loadFiles = [];
        foreach ($dir_list as $file) {
            $fileData = pathinfo(basename($file));
            /* Search for the main database */
            if (in_array($fileData['basename'], $neededFiles)) {
                $loadFiles[] = $file;
            }
            /**
             * If it is a log file ---> search the latest
             * */
            if (preg_match($pattern, $fileData['basename'])) {
                $time = $ftp->mdtm($file);
                if ($time > $mostRecent['time']) {
                    $mostRecent['time'] = $time;
                    $mostRecent['file'] = $file;
                }
            }
        }
        if (isset($mostRecent['file'])) {
            $loadFiles[] = $mostRecent['file'];
        }
        if (count($loadFiles) == 2) {
            $localFiles = [];
            foreach ($loadFiles as $filename) {
                $localFile = $this->localPath . basename($filename);
                $localFiles[] = $localFile;
                $f = fopen($localFile, "w+");
                $ftp->fget($f, $filename, FTP_BINARY);
                fclose($f);
            }
            $this->importDB($localFiles);
        }

    }

    function importDB($localFiles)
    {
        /* import main db data */
        $db_path = $localFiles[0];
        $accessTables = ['DeviceInputs', 'Users', 'Keys', 'EventTypes'];
        $this->importMSAccessDB($db_path, $accessTables);
        /* import event db data */
        $db_path = $localFiles[1];
        $accessTables = ['KeyEvents'];
        $this->importMSAccessDB($db_path, $accessTables);
        $lastRecords = $this->getLastData();
        foreach ($lastRecords as $key => $row) {
            $lastRecords[$key] = array_values($row);
        }
        //var_dump($lastRecords);
        $uploadForm = new UploadForm();
        $uploadForm->importData($lastRecords, false);
        echo "Yahooo! It's done!";
        /*$excel = new Excel();
        $excel->generateFromArray($lastRecords,"tmp",true);*/
    }

    function getLastData()
    {
        $records = (new Query())
            ->select(["bb_keyevents.EventID",
                "DATE(bb_keyevents.EventDate)",
                "DATE_FORMAT(bb_keyevents.EventDate,'%H:%i:%s') as enter_time",
                "bb_deviceinputs.DeviceInputName",
                "bb_eventtypes.EventName",
                "TRIM(CONCAT(bb_users.UserSurName,' ',bb_users.UserFirstName,' ',bb_users.UserLastName)) as full_name"])
            ->from('bb_keyevents')
            ->join('join', 'bb_eventtypes', 'bb_eventtypes.EventTypeID = bb_keyevents.EventTypeID')
            ->join('join', 'bb_keys', 'bb_keys.KeyID = bb_keyevents.Object1ID')
            ->join('join', 'bb_users', 'bb_users.UserID = bb_keys.UserID')
            ->join('join', 'bb_deviceinputs', 'bb_deviceinputs.DeviceInputID = bb_keyevents.Object2ID')
            ->where(['bb_keyevents.EventTypeID' => 123])
            ->all();
        return $records;
    }

    function importMSAccessDB($path, $tables)
    {
        $connection = \Yii::$app->db;//get connection
        foreach ($tables as $tableName) {
            $exportFile = $path . $tableName . ".csv";
            $command = "mdb-export $path $tableName > " . $exportFile . " 2>&1";
            $output = exec($command);
            if (file_exists($exportFile)) {
                $sqlTableName = "bb_" . strtolower($tableName);
                $modelName = "backend\\models\\" . str_replace(' ', '', ucwords(str_replace('_', ' ', $sqlTableName)));
                $model = new $modelName();
                $fields = array_map(function ($el) {
                    return $el == "EventDate" ? "@EventDate" : $el;
                }, $model->getTableSchema()->getColumnNames());
                $connection->createCommand()->truncateTable($sqlTableName)->execute();
                $this->csvToSQL($sqlTableName, $fields, $exportFile);

            }
        }
    }

    function csvToSQL(
        $table,        // Имя таблицы для импорта
        $afields,        // Массив строк - имен полей таблицы
        $filename,        // Имя CSV файла, откуда берется информация
        // (путь от корня web-сервера)
        $delim = ',',        // Разделитель полей в CSV файле
        $enclosed = '"',    // Кавычки для содержимого полей
        $escaped = '\\\\',        // Ставится перед специальными символами
        $lineend = '\\n',    // Чем заканчивается строка в файле CSV
        $hasheader = true)
    {    // Пропускать ли заголовок CSV

        if ($hasheader) $ignore = "IGNORE 1 LINES ";
        else $ignore = "";
        $q_import =
            "LOAD DATA INFILE '" . $filename . "' INTO TABLE " . $table . " " .
            "FIELDS TERMINATED BY '" . $delim . "' ENCLOSED BY '" . $enclosed . "' " .
            "    ESCAPED BY '" . $escaped . "' " .
            "LINES TERMINATED BY '" . $lineend . "' " .
            $ignore .
            "(" . implode(',', $afields) . ")";;
        if ($table == "bb_keyevents") {
            $q_import .= " SET EventDate = STR_TO_DATE(@EventDate, '%m/%d/%Y %H:%i:%s');";
        }
        \Yii::$app->db->createCommand($q_import)->execute();
    }


}