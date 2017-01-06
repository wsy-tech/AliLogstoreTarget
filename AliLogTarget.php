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
use \Aliyun_Log_Client;
use \Aliyun_Log_Models_LogItem;
use \Aliyun_Log_Models_PutLogsRequest;
use \Aliyun_Log_Exception;
//require_once "./Log_Autoload.php";
class AliLogTarget extends Target
{
    public $endpoint;  //端点，服务所在区域
    public $accessKeyId; //使用你的阿里云访问秘钥AccessKeyId
    public $accessKey; //使用你的阿里云访问秘钥AccessKeySecret
    public $project; //项目名称
    public $logstore; //日志库名称
    private $client;

    public function init()
    {
        parent::init();
        $this->client = new \Aliyun_Log_Client($this->endpoint, $this->accessKeyId, $this->accessKey);
    }



    function putLogs($topic = '')
    {
        //$this->client = new \Aliyun_Log_Client($this->endpoint, $this->accessKeyId, $this->accessKey);

        $contents = array(
            'TestKey' => 'TestContent'
        );
        $logItem = new \Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents($contents);
        $logitems = array($logItem);
        $request = new \Aliyun_Log_Models_PutLogsRequest($this->project, $this->logstore,
            $topic, null, $logitems);

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
}
