# MailSender

使用 PHP 和 PHPMailer 实现

可用于 哪吒探针 项目的邮件通知



## Start

### Docker Compose

```yaml
services:
  MailSender:
    image: rexlee929/mailsender:latest
    container_name: sender
    restart: always
    ports:
      - "127.0.0.1:6003:80"
    environment:
      - AUTH_KEY=key #这里请修改任意值
    volumes:
      - '/etc/localtime:/etc/localtime:ro'
    networks:
      - MailSender
      
networks:
  MailSender:
    driver: bridge
    driver_opts:
      com.docker.network.bridge.name: "MailSender"
    ipam:
      config:
        - subnet: 172.28.0.0/24
          gateway: 172.28.0.1
```



### Nezha Monitoring



#### 新增 通知方式



#### URL

```bash
http://ip:port/send.php
```

如果使用反向代理则填写

```bash
https://domain.com/send.php
```



#### 请求方式

`POST`



#### 请求类型

`JSON`



#### Header

```json
{
    "X-Auth-Key": "key"
}
```



#### Body

```json
{
    "subject": "Nezha Monitoring",
    "content": "#NEZHA#",
    "smtpHost": "smtp.domain.com",
    "smtpPort": 587,
    "smtpUser": "name@domain.com",
    "smtpPass": "password",
    "fromEmail": "name@domain.com",
    "toEmail": "name@domain.com"
}
```



## 问题排查

* 查看容器日志

  ```bash
  docker logs -f sender
  ```

* 通过 `CURL` 测试

  ```bash
  curl -X POST http://ip:9050/send.php \
       -H "Content-Type: application/json" \
       -H "X-Auth-Key: key" \
       -d '{
             "subject": "Nezha Monitoring",
             "content": "#NEZHA#",
             "smtpHost": "smtp.domain.com",
             "smtpPort": 587,
             "smtpUser": "name@domain.com",
             "smtpPass": "password",
             "fromEmail": "name@domain.com",
             "toEmail": "name@domain.com"
           }'
  ```

  

  