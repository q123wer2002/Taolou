總共頁面列表
============
使用者看：

1. 首頁(職業列表) => index.php, 完成!
2. 職位頁面 => job.html
3. 公司頁面
4. 專題頁面
5. 專題10家公司頁面 => topic.html
6. 登入頁面 => account.php, 完成!
7. 搜尋結果頁面

個人登入後：

1. 求職管理頁面 => jobManage.php, 完成!
2. 在線履歷頁面 => userMe.php, 完成!
3. 私信頁面 => userMessage.php, 完成!
4. 履歷管理頁面 => userResume.php, 完成!
5. 履歷上傳頁面 => userResume.php, 完成!
6. 申請工作頁面
7. 帳號管理頁面 => userSetting.php, 完成!

企業登入後：

1. 私信頁面 => userMessage.php
2. 公司資料編輯頁面
3. 帳號管理頁面
4. 發布職位頁面 => post_job.html

缺少元素
===========
1. 幻燈片
2. 主題
3. 合作公司
4. 扛霸子介紹
5. 起始職缺
6. 會員說明書

撰寫前規則
===========
1. layout.html是板型，寫每個頁面都可以用(如果不需要廣告，可以把直接把上面廣告的div刪掉)
2. 內容直接寫在 &lt;div class='body'&gt;&lt;/div&gt;  內，寬度 '1024px'
3. 在 &lt;div class='body'&gt;&lt;/div&gt; 上面載入此頁面專屬的 css
4. 需要重複的地方，可以用簡單的 angularjs，方法如下
&lt;p ng-repeat='i in [1,2,3]'&gt;你好{{i}}&lt;/p&gt;
這樣就會出現 
&lt;p&gt;你好1&lt;/p&gt;
&lt;p&gt;你好2&lt;/p&gt;
&lt;p&gt;你好3&lt;/p&gt;

架構
======
1. 主要分成 css, js, images, font這幾個資料夾，分別放該放的東西
2. 頁面製作主要以當初ppt上面的function頁面製作
3. 有一個layout.html，主要是板型的html
4. 每個檔案都會用到的東西都放在layout裡面，像layout.css, layout.js等等
5. 寫的html主要以清晰，擴充性高，易閱讀為主

