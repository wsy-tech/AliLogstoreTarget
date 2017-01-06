# AliLogstoreTarget
将yii日志收集到阿里云日志服务
## Configuration
打开config/web.php或main.php，配置如下
<pre><code>
return [
    //....
    'components' => [
        'log' => [
            'targets' => [
                'class' => 'wsy\log\AliLogTarget',
                'endpoint' =>'节点',
                'accessKeyId' => '阿里云访问秘钥AccessKeyId',
                'accessKey' => '阿里云访问秘钥AccessKeySecret',
                'project' => '项目名称',
                'logstore' => '日志库名称',
            ]
        ]
    ]
];
</code></pre>
