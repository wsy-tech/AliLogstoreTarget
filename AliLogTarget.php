<?php namespace wsy\log;

/**
 * Hangzhou Yunshang Network Technology Inc.
 * http://www.wsy.com
 * ==============================================
 * User: shiq
 * Date: 2017/1/5
 * Time: 17:08
 */
use yii\log\Target;
require_once \Yii::$app->basePath.'/../vendor/alilog/yii2-ali-log/Log_Autoload.php';
class AliLogTarget extends Target
{
    public $endpoint;  //端点，服务所在区域
    public $accessKeyId; //使用你的阿里云访问秘钥AccessKeyId
    public $accessKey; //使用你的阿里云访问秘钥AccessKeySecret
    public $project; //项目名称
    public $logstore; //日志库名称
    public $topic = 'log'; //
    private $client;

    public function init()
    {
        parent::init();
        $this->client = new \Aliyun_Log_Client($this->endpoint, $this->accessKeyId, $this->accessKey);
    }



    function putLogs()
    {
        $contents = array();
        foreach ($this->messages as $message){
            $text = $this->formatMessage($message);
            $contents[$this->topic] = $text;
        }
        $logItem = new \Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents($contents);
        $logitems = array($logItem);
        $request = new \Aliyun_Log_Models_PutLogsRequest($this->project, $this->logstore,
            $this->topic, null, $logitems);

        try {
            $response = $this->client->putLogs($request);
            $info = $response->getHeader('_info');
            return ($info['http_code']);
        } catch (\Aliyun_Log_Exception $ex) {
            return $ex->getErrorMessage();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function export()
    {
        $this->putLogs();
    }
}
