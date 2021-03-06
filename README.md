[![SafeCrow](safecrow.svg)](https://www.safecrow.ru/)
# Документация API SafeCrow V3
##### версия документа 3.09
### Версии документа

Версия | Дата | Предмет изменений
------------ | ------------- | -------------
3.01 | 22-02-2018 | Первый выпуск документа
3.02 | 19-03-2018 | Добавлена возможность прикреплять файлы к сделке и просматривать их
3.03 | 27-03-2018 | Изменен текст ошибок,метод оплаты комиссии,запрос для выплаты продавцу, метод отмены, метод открытия претензии. Добавлена возможность оплаты доставки через сервис (Эквайринг за доставку). Добавлен метод расчета стоимости комиссии SafeCrow, стоимости доставки и отмены.
3.04 | 11-04-2018 | Добавлена функция преавторизации платежей в разделе "Дополнительные возможности".
3.05 | 13-02-2019 | Добавлена функция удаления банковской карты.
3.06 | 26-02-2019 | Добавлена информация поиска пользователя по номеру телефона.
3.07 | 18-06-2019 | Добавлена информация по работе с юридическими лицами.
3.08 | 26-06-2019 | Добавлена информация по отправке уведомлений при работе с юридическими лицами.
3.09 | 24-07-2019 | Добавлена информация по работе с нерезидентами РФ.

## Оглавление
1. [Введение](#intro)
2. [Бизнес–процесс](#step-deal)
3. [Авторизация](#authorization)
4. [Регистрация пользователя](#reg)
5. [Посмотреть список пользователей](#user-list)
6. [Посмотреть данные пользователя](#user-info)
7. [Редактировать данные пользователя](#user-edit)
8. [Расчет стоимости комиссии SafeCrow](#calculate)
9. [Создание сделки](#create)
10. [Просмотр сделок](#show-deal)
11. [Аннулирование сделки](#deleted)
12. [Оплата сделки](#pay)
13. [Оплата сделки (для юр.лиц)](#pay-business)
    1. [Подтверждение оплаты (сallback)](#pay-business-callback)
14. [Привязать банковскую карточку к пользователю](#user-card)
15. [Посмотреть привязанные к пользователю карты](#show-user-cards)
16. [Привязать карту к сделке](#bind-card)
17. [Удалить карту](#delete-card)
18. [Привязать банковский счет к пользователю (для юр.лиц)](#user-bank-account)
19. [Привязать банковский счет в банке-респонденте к счету в банке-корреспонденте (или наоборот)](#respondent-correspondent)
20. [Посмотреть привязанные к пользователю банковские счета](#show-user-bank-accounts)
21. [Посмотреть список счетов респондентов/корреспондентов](#show-respondent-correspondent)
22. [Привязать счет к сделке](#bind-bank-account)
23. [Удалить банковский счет](#delete-bank-account)
24. [Отменить сделку](#canceled)
    1. [Отменить сделку (callback для юр.лиц)](#cancel_bus)
25. [Закрыть сделку](#close)
    1. [Закрыть сделку (для юр.лиц)](#close_bus)
26. [Эскалировать сделку/открыть претензию](#escalate)
27. [Добавить вложение (Attachments)](#add-attachments)
28. [Просмотреть вложения](#show-attachments)
29. [Подтверждение получения товара (для юр.лиц)](#confirm-receive)
30. [Отправка закрывающих документов (для юр.лиц)](#send-docs)
31. [Настройки](#settings)
32. [Другие ошибки](#errors)
### Дополнительные возможности
1. [Эквайринг за доставку](#acquiring)
2. [Преавторизация платежей](#preauth)


## <a name="intro">Введение</a>
**API SafeCrow V3** – это набор инструментов, которые позволяют использовать сервис и технологии SafeCrow в ваших проектах.
Документ состоит из двух частей:
1.    Основная часть
2.    Дополнительные возможности

В основной части документа описан функционал SafeCrow.

Для того, чтобы получить доступ к функционалу, который описан во второй части, необходимо обратиться к вашему менеджеру и заключить договор на дополнительные услуги.

**Важная информация!**
При интеграции API SafeCrow ваши пользователи должны принять оферту SafeCrow, которая расположена по адресу: https://www.safecrow.ru/term . Оферта должна быть принята пользователями до момента оплаты.

Все суммы в коде указаны в копейках.


## <a name="step-deal">Бизнес–процесс</a>
Последовательность шагов для создания и проведения сделки изображена на **рис. 1.**

**Важно!**
Данный процесс изменился  по сравнению с версий v1.

![step-deal](step-deal.jpg)
  Рис.1


## <a name="authorization">Авторизация</a>
В API V3 авторизация сделана прозрачной, в основе нее `http basic auth` и `hmac подписи`.

В качестве логина надо использовать `api-key`, в качестве пароля `hmac подпись` тела запроса ключом `api-secret`.

Пример запроса на Python, PHP и Ruby содежатся  в репозитории.


## <a name="reg">Регистрация (создание) пользователя</a>
Для создания/регистрации пользователя следует использовать запрос `POST /users` и указать следующие переменные:

| Переменные |     Данные    | Примечание
------------ | ------------- | ----------
| **Обязательные**
| name | Имя Фамилия
| phone | Номер мобильного телефона | Можно не указывать, если указан email
| email | e-mail пользователя | Можно не указывать, если указан телефон
| inn | ИНН | Только для юр. лиц
| ogrn | ОГРН | Только для юр. лиц резидентов РФ
| legal_address | Юр. адрес | Только для юр. лиц
| physical_address | Физ. адрес | Только для юр. лиц
| **Опциональные**
| business | Юр. лицо? | true \|\| [false]
| kpp | КПП | Только для юр. лиц
| ceo_name | ФИО руководителя | Только для юр. лиц
| ceo_position | Должность руководителя | Только для юр. лиц
| warrant | Основание для действия | Только для юр. лиц
| contact_name | ФИО контактного лица | Только для юр. лиц
| contact_position | Должность контактного лица | Только для юр. лиц
| origin | Страна, [формат ISO 3166-2](https://ru.wikipedia.org/wiki/ISO_3166-2) | Только для юр. лиц, если не указано = 'RU'

*Пример запроса*

```json
POST /users

{
  "email": "ivan@example.com",
  "phone": "79998887777",
  "name": "Иван Иванов"
}
```

*Пример запроса для юридического лица*

```json
POST /users

{
  "email": "ivan@example.com",
  "phone": "79998887777",
  "name": "Иван Иванов",
  "business": true,
  "inn": "1234567890",
  "ogrn": "12345677890123",
  "legal_address": "г.Москва, ул. Международная, д.1",
  "physical_address": "г.Москва, ул. Международная, д.1"
}
```
**Примечание**: ИНН проверяется не только на наличие и длину поля, но и на то, [корректно ли он сформирован](https://www.egrul.ru/test_inn.html).

*Пример ответа*
```json
{
  "id": 467,
  "email": "ivan@example.com",
  "phone": "79998887777",
  "name": "Иван Иванов",
  "registered_at": "2018-02-05T12:17:01+03:00",
  "origin": "RU"
}
```

*Пример ответа для юридического лица*
```json
{
  "id": 467,
  "email": "ivan@example.com",
  "phone": "79998887777",
  "name": "Иван Иванов",
  "props": {
    "inn": "1234567890",
    "ogrn": "12345677890123",
    "legal_address": "г.Москва, ул. Международная, д.1",
    "physical_address": "г.Москва, ул. Международная, д.1"
  },
  "registered_at": "2018-02-05T12:17:01+03:00",
  "origin": "RU"
}
```
Создан пользователь 467, 5 февраля 2018 в 12:17

#### Сообщения об ошибках:
*Пример*
```json
{
  "errors": [
    { "name": "required field" },
    { "email": "user with email ivan@example.com and/or phone 79251234567 already exists" }
  ]
}
```
**`“required field”`** - ошибка в обязательном поле. Поле либо не было передано, либо содержит ошибку.


## <a name="user-list">Посмотреть список пользователей</a>
Для просмотра зарегистрированных пользователей достаточно ввести следующий запрос:

*Пример запроса*
```json
GET /users
```
Для поиска пользователя по email к запросу нужно добавть параметр email

*Пример запроса*
```json
GET /users?email=test@email.com
```

Для поиска пользователя по телефону к запросу нужно добавть параметр phone

*Пример запроса*
```json
GET /users?phone=79998887777
```

*Пример ответа*
```json
{
  "id": 467,
  "email": "test@email.com",
  "phone": "79998887777",
  "name": "Вася Васильев",
  "registered_at": "2018-02-05T12:17:01+03:00",
  "origin": "RU"
}
```


## <a name="user-info">Посмотреть данные пользователя</a>
Для просмотра данных пользователя, используйте запрос: `GET /users/:user_id`

*Пример запроса*
```json
GET /users/467
```

*Пример ответа*
```json
{
  "id": 467,
  "email": "test@email.com",
  "phone": "79998887777",
  "name": "Вася Васильев",
  "registered_at": "2018-02-05T12:17:01+03:00",
  "origin": "RU"
}
```


## <a name="user-edit">Редактировать данные пользователя</a>
Редактировать и добавить данные пользователю можно используя запрос `POST /users/:user_id`. Можно изменить следующие переменные:

Переменные | Данные
------------ | -------------
**Обязательные** |
email | e-mail пользователя
name | Имя Фамилия
phone | номер мобильного телефона

*Пример запроса*
```json
POST /users/467

{
  "phone": "79998887777",
  "name": "Иван Васильев"
}
```

*Пример ответа*
```json
{
  "id": 467,
  "email": "test@email.com",
  "phone": "79998887777",
  "name": "Иван Васильев",
  "registered_at": "2018-02-05T12:17:01+03:00",
  "origin": "RU"
}
```

У пользователя 467 были изменены телефон и имя.

*Пример запроса для юр.лица*
```json
POST /users/467

{
  "name": "Иван Васильев",
  "inn": "3664069397"
}
```

*Пример ответа для юр.лица*
```json
{
  "id": 468,
  "email": "test@email.com",
  "phone": "79998887777",
  "name": "Иван Васильев",
  "registered_at": "2018-02-05T12:17:01+03:00",
  "props": {
    "inn": "3664069397",
    "ogrn": "1234215145134",
    "legal_address": "Moscow",
    "physical_address": "Moscow"
  },
  "origin": "RU"
}
```
У пользователя 468 был изменен ИНН.

**Примечание**: нельзя обновить заполненное поле на пустое.


## <a name="calculate">Расчет стоимости комиссии SafeCrow</a>
Для расчета стоимости комиссии SafeCrow используйте `POST /calculate`.

Поле `consumer_cancellation_cost` входит в разряд дополнительных возможностей и требует отдельного договора. Данное поле предоставляет возможность оштрафовать Покупателя за отмену, по вашему желанию. Например, если товар уже ушел от Продавца Покупателю, оштрафовать Покупателя на стоимость обратной доставки.
Поле `with_foreign` позволяется при расчете комиссии учитывать ставку партнера при работе с нерезидентами РФ.

Переменные | Данные
------------ | -------------
price | стоимость сделки, в копейках
service_cost_payer | “50/50” или “consumer” или “supplier”
**Второстепенные** |
consumer_cancellation_cost | штраф покупателя за отмену. сумма в копейках
with_foreign | Как минимум одна из сторон сделки - нерезидент РФ [true\false]

*Пример запроса*

```json
POST /calculate

{
  "price":100000,
  "service_cost_payer":"50/50",
  "consumer_cancellation_cost": 0
}
```

*Пример ответа*
```json
{
  "price":100000,
  "supplier_service_cost":2000,
  "consumer_service_cost":2000,
  "consumer_cancellation_cost": 0
}
```


## <a name="create">Создание сделки</a>
Для создания сделки следует использовать `POST /orders` и указать следующие переменные:

Поле `with_foreign` позволяется при расчете комиссии учитывать ставку партнера при работе с нерезидентами РФ.

| Переменные | Данные
------------ | -------------
**Обязательные** | |
| consumer_id | integer
| supplier_id | integer
| price | integer (в копейках, минимум 100 руб (10000))
| description | string
| service_cost_payer | “50/50” или “consumer” или “supplier”
**Второстепенные** | |
| extra | ассоциативный массив - дополнительная информация
| with_foreign | Как минимум одна из сторон сделки - нерезидент РФ (true\false)

*Пример запроса*
```json
POST /orders

{
  "consumer_id": 467,
  "supplier_id": 466,
  "price": 10000,
  "description":"something",
  "service_cost_payer":"50/50"
}
```

*Пример ответа*
```json
{
  "id": 37606,
  "consumer_id": 467,
  "supplier_id": 466,
  "price": 10000,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": null,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "status": "pending",
  "description": "something",
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T14:35:08+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```
**Примечание**: для юр. лиц в ответе поля *_payment_method_type и *_payout_method_type будут иметь значение `BankAccount`

Была создана сделка 29, стоимость сделки 100 рублей, комиссия составляет 4 рубля и  платится пользователями пополам. В этот момент статус сделки становится `“pending”`.
#### Сообщения об ошибках:
**`"extra": "Некорректный тип данных"`** - должен передаваться ассоциативный массив `ключ-значение`


## <a name="show-deal">Просмотр сделок</a>
Посмотреть данные **всех сделок** - `GET /orders`

Посмотреть **сделку по id** - `GET /orders/:order_id`

Посмотреть данные сделок **конкретного пользователя по его id** - `GET /users/:user_id/orders`

*Пример запроса*
```json
GET /users/467/orders
```

*Пример ответа*
```json
[
  {
    "id": 30,
    "description": "something",
    "price": 10000,
    "supplier_id": 467,
    "consumer_id": 466,
    "status": "preauthorized",
    "consumer_payout_method_id": null,
    "supplier_payout_method_id": 28198,
    "consumer_payout_method_type": "CreditCard",
    "supplier_payout_method_type": "CreditCard",
    "consumer_service_cost": 500,
    "supplier_service_cost": 500,
    "consumer_delivery_cost": 0,
    "supplier_delivery_cost": 0,
    "consumer_cancellation_cost": 0,
    "discount": 0,
    "consumer_payment_method_type": "CreditCard",
    "consumer_payment_method_id": null,
    "created_at": "2019-06-17T14:35:08+03:00",
    "updated_at": "2019-06-17T16:40:40+03:00",
    "foreign_supplier_payout_method_id": null,
    "foreign_consumer_payout_method_id": null,
    "foreign_supplier_payout_method_type": null,
    "foreign_consumer_payout_method_type": null,
    "foreign_consumer_payment_method_type": null,
    "foreign_consumer_payment_method_id": null,
    "extra": {
    }
  }
]
```
В ответ на запрос придет список всех сделок, в которых участвовал пользователь.
В данном примере к пользователю привязана одна сделка.


## <a name="deleted">Аннулирование сделки</a>
Аннулирование возможно только до проведения оплаты по сделке.

Для аннулирования активной сделки используется запрос `POST /orders/:order_id/annul` и данные:

Переменные | Данные
------------ | -------------
**Обязательные** |
reason | string

*Пример запроса*
```json
POST /orders/31/annul

{
  "reason": "Some reason"
}
```

*Пример ответа*
```json
{
  "id": 30,
  "description": "something",
  "price": 10000,
  "supplier_id": 467,
  "consumer_id": 466,
  "status": "annulled",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```


## <a name="pay">Оплата сделки</a>
Для оплаты сделки в запросе указывается номер `(id)` сделки, которая будет оплачена Покупателем `(consumer)` - `POST /orders/:order_id/pay`.
Также необходимым полем является переменная `redirect_url` - ссылка на страницу, куда будет направлен пользователь после оплаты.

Переменные | Данные
------------ | -------------
**Обязательные** |
redirect_url | cсылка (String)

Для проведения тестовых оплат используйте тестовые карточки шлюза “MandarinPay”:

Параметры | Значение | Комментарий
------------- | ------------- | -------------
Номер карты | 4929509947106878 | Для имитации успешных транзакций без 3DSecure
Номер карты | 4692065455989192 | Для имитации успешных транзакций с 3DSecure
Номер карты | 4485913187374384 | Для имитации неуспешных транзакций без 3DSecure
Номер карты | 4556058936309366 | Для имитации неуспешных транзакций с 3DSecure
Имя держателя карты | CARD HOLDER |
Срок действия | Любой валидный | 	Минимально - выбрать месяц, следующий за текущим
CVV | 123 |

Далее пример запроса на оплату ранее созданной сделки  29 и получения в ответ ссылки на оплату.

*Пример запроса*
```json
POST /orders/29/pay

{
  "redirect_url": "http://example.com/return/url"
}
```

*Пример ответа*
```json
{
  "payment_url": "https://secure.mandarinpay.com/f/rcl1/?operationId=transaction_e0db10aecacc44ea9fbc1dd335a94a70&locale=en",
  "consumer_pay": 102000
}
```
В ответе по ссылке осуществляется оплата, после чего происходит редирект на указанный в запросе url, к которому добавляются параметры:

Параметры | Данные
------------ | -------------
orderId | id сделки + _ + случайное число  (11_a43234)
status | success или failed
type | pay

*Пример ссылки*
```
http://example.com/return/url?orderId=29_a44298&status=success&type=pay
```
Cтатус сделки изменится на `paid`.


## <a name="pay-business">Оплата сделки (для юр.лиц)</a>
Для оплаты сделки в запросе указывается номер `(id)` сделки, которая будет оплачена Покупателем `(consumer)` - `POST /orders/:order_id/pay`.

*Пример ответа*
```json
{
  "pdf": "https://staging.safecrow.ru/static/payments/37610/order-37610.pdf",
  "consumer_pay": 1050000
}
```

В ответе по ссылке находится платежный документ в формате PDF.

### <a name="pay-business-callback">Подтверждение оплаты (сallback)</a>

При подтверждении оплаты партнеру по [зарегистрированному](#settings) `callback_url` уходит уведомление

*Пример уведомления*

```json
{
  "id": 468,
  "status": "paid"
}
```


## <a name="user-card">Привязать банковскую карточку к пользователю</a>
Для привязки карты используйте запрос - `POST /users/:user_id/cards`


Переменные | Данные
------------ | -------------
redirect_url | ссылка (String)

*Пример запроса*
```json
POST /users/467/cards

{
  "redirect_url": "http://example.com/return/url"
}
```

*Пример ответа*
```json
{
  "redirect_url": "https://safecrow.ru/finances/card_binding/467?jsOperationId
  =binding_5ae972a2-e5bb-4913-83a1-ac7408e30f54&return_to="
}
```

В ответ приходит ссылка на заполнение данных банковской карты.

**Сообщения об ошибках:**
**`"phone": [ "Can not be empty!" ]`** - к пользователю должен быть привязан телефонный номер ([привязать](#user-edit), изменив данные пользователя)


## <a name="show-user-cards">Посмотреть привязанные к пользователю карты</a>
После заполнения данных карты, она привязывается к пользователю, список всех привязанных  карт, включая неудачные попытки можно узнать, используя `GET /users/:user_id/cards?all=true`

Для просмотра всех банковских карт, подтвержденных мандарином `GET /users/:user_id/cards`

*Пример запроса*
```json
GET /users/467/cards
```

*Пример ответа*
```json
[
  {
    "id": 179,
    "card_holder": "CARD HOLDER",
    "card_number": "492950XXXXXX6878",
    "expires": "10/20",
    "bound_at": "2018-02-06T16:46:22+03:00",
  }
]
```
Если карта не была привязана - в ответ придет пустой список.


## <a name="bind-card">Привязать карту к сделке</a>
Для выплаты продавцу `(supplier)` будет использована одна из ранее привязанных к нему карт, к запросу `POST /users/:user_id/orders/:order_id` требуется добавить `переменную id` карты – [узнать id](#show-user-cards).

*Пример запроса*
```json
POST /users/466/orders/29

{
  "supplier_payout_card_id": 467
}
```

*Пример ответа*
```json
{
  "id": 467,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "paid",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```
Ответ - описание сделки, в полях `supplier_payout_method_id` и `type` указана информация соответственно об `id карты` и `типе выплаты`.


## <a name="delete-card">Удалить карту</a>
Для удаления карты необходимо обратиться к `/users/:user_id/cards/:card_id/delete`

*Пример запроса*
```json
POST /users/466/cards/123/delete
```

*Пример ответа*
```json
{
  "id": 467,
  "result": "deleted"
}
```


## <a name="user-bank-account">Привязать банковский счет к пользователю (для юр.лиц)</a>
Для привязки счета используйте запрос - `POST /users/:user_id/accounts`


Переменные | Данные | Примечание
-|-|-
account | Р/С | необязательно для счета банка корреспондента
corr_account | К/С
bik | БИК
bank_name | Название банка
origin | Страна, [формат ISO 3166-2](https://ru.wikipedia.org/wiki/ISO_3166-2) | если не указано = 'RU'

*Пример запроса*
```json
POST /users/467/accounts

{
  "account": "XXXXXXXXXXXXXXXXXXXX",
  "corr_account": "XXXXXXXXXXXXXXXXXXXX",
  "bik": "XXXXXXXX",
  "bank_name": "АО СБЕРБАНК"
}
```

*Пример ответа*
```json
{
  "id": 456,
  "account": "XXXXXXXXXXXXXXXXXXXX",
  "corr_account": "XXXXXXXXXXXXXXXXXXXX",
  "bik": "XXXXXXXX",
  "bank_name": "АО СБЕРБАНК",
  "origin": "RU"
}
```
**Примечание**: Номера счетов банков РФ проверяются на правильность формирование по БИК


## <a name="respondent-correspondent">Привязать банковский счет в банке-респонденте к счету в банке-корреспонденте (или наоборот)</a>
Для привязки используйте запрос - `POST /users/:user_id/accounts/account_id`

Переменные | Данные
-|-
relation | Роль банка который привязывается, 'respondent' или 'correspondent'
account_id | ID счета который привязывается

*Пример запроса*
```json
POST /users/467/accounts/123

{
  "relation": "respondent",
  "account_id": 122
}
```

*Пример ответа*
```json
{
  "id": 122,
  "account": "XXXXXXXXXXXXXXXXXXXX",
  "corr_account": "XXXXXXXXXXXXXXXXXXXX",
  "bik": "XXXXXXXX",
  "bank_name": "Нурбанк",
  "origin": "KZ"
}
```

К корреспонденту (id = 123) привязывается респондент (id = 122)


## <a name="show-respondent-correspondent">Посмотреть список счетов респондентов/корреспондентов</a>
Для **респондентов** `GET /users/:user_id/accounts/:account_id/respondents`

Для **корреспондентов** `GET /users/:user_id/accounts/:account_id/correspondents`

*Пример запроса*
```json
GET /users/467/accounts/122/correspondents
```

*Пример ответа*
```json
[
  {
    "id": 123,
    "account": "XXXXXXXXXXXXXXXXXXXX",
    "corr_account": "XXXXXXXXXXXXXXXXXXXX",
    "bik": "XXXXXXXX",
    "bank_name": "АО СБЕРБАНК",
    "origin": "RU"
  }
]
```


## <a name="show-user-bank-accounts">Посмотреть привязанные к пользователю банковские счета</a>
Список всех привязанных счетов можно узнать, используя `GET /users/:user_id/accounts`

*Пример запроса*
```json
GET /users/467/accounts
```

*Пример ответа*
```json
[
  {
    "id": 456,
    "account": "XXXXXXXXXXXXXXXXXXXX",
    "corr_account": "XXXXXXXXXXXXXXXXXXXX",
    "bik": "XXXXXXXX",
    "bank_name": "АО СБЕРБАНК",
    "origin": "RU"
  }
]
```
Если счетов не было привязано - в ответ придет пустой список.


## <a name="bind-bank-account">Привязать счет к сделке</a>
Для привязки участнику сделки будет использован один из ранее привязанных к нему счетов, к запросу `POST /users/:user_id/orders/:order_id` требуется добавить `переменную id` счета – [узнать id](#show-user-bank-accounts).

**Примечание**:

Перед привязкой счета в банке-нерезиденте РФ нужно предварительно [привязать](#respondent-correspondent) его в качестве респондента к соответствующему банку-корреспонденту РФ.

*Пример запроса*
```json
POST /users/466/orders/29

{
  "account_id": 2628
}
```

*Пример ответа*
```json
{
  "id": 37610,
  "description": "something",
  "price": 1000000,
  "supplier_id": 98921,
  "consumer_id": 98920,
  "status": "pending",
  "created_at": "2019-06-18T14:16:56+03:00",
  "updated_at": "2019-06-18T14:37:21+03:00",
  "consumer_payout_method_id": 2628,
  "supplier_payout_method_id": null,
  "consumer_payout_method_type": "BankAccount",
  "supplier_payout_method_type": "BankAccount",
  "consumer_service_cost": 50000,
  "supplier_service_cost": 50000,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "BankAccount",
  "consumer_payment_method_id": null,
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  },
}
```
Ответ - описание сделки, в полях `consumer_payout_method_id` и `type` указана информация соответственно об `id счета` и `типе выплаты`.

Если счет какой-либо стороны открыт в банке-нерезиденте РФ, то данные об оплате/выплате будут в соответсвующих полях `foreign_*`.

*Пример ответа, если счет продавца открыт в банке-нерезиденте РФ*
```json
{
  "id": 37610,
  "description": "something",
  "price": 1000000,
  "supplier_id": 98921,
  "consumer_id": 98920,
  "status": "pending",
  "created_at": "2019-06-18T14:16:56+03:00",
  "updated_at": "2019-06-18T14:37:21+03:00",
  "consumer_payout_method_id": 2628,
  "supplier_payout_method_id": null,
  "consumer_payout_method_type": "BankAccount",
  "supplier_payout_method_type": null,
  "consumer_service_cost": 50000,
  "supplier_service_cost": 50000,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "BankAccount",
  "consumer_payment_method_id": null,
  "foreign_supplier_payout_method_id": 3739,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": "BankAccount",
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  },
}
```

## <a name="delete-bank-account">Удалить банковский счет</a>
Для удаления счета необходимо обратиться к `/users/:user_id/accounts/:account_id/delete`

*Пример запроса*
```json
POST /users/466/accounts/2628/delete
```

*Пример ответа*
```json
{
  "id": "2628",
  "result": "deleted"
}
```


## <a name="canceled">Отменить сделку</a>
Отмена производится в том случае, если оплата по сделке уже прошла, в ином случае производится Аннулирование сделки.
Обратите внимание, что при отмене сделки вся комиссия сервиса списывается с покупателя `(consumer)`.

Сделку можно отменить, используя следующий запрос:
`POST /orders/:order_id/cancel`

Переменные | Данные
------------ | -------------
reason | String

*Пример запроса*
```json
POST /orders/51/cancel

{
  "reason": "Some important reason"
}
```

*Пример ответа*

```json
{
  "id": 467,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "cancelled",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```

Сделка переходит в статус - отмена  `(cancelled)`. Покупателю возвращается сумма оплаты - 100 рубля.


### <a name="cancel_bus">Отменить сделку (callback для юр.лиц)</a>
Партнеру по [зарегистрированному](#settings) `callback_url` уходит уведомление

*Пример уведомления если сделка была в статусе paid*

```json
{
  "id": 468,
  "status": "cancelled"
}
```

*Пример уведомления если сделка была в статусе pending*

```json
{
  "id": 468,
  "status": "annulled"
}
```


## <a name="close">Закрыть сделку</a>
Успешное завершение сделки - `POST /orders/:order_id/close`

Переменные | Данные
------------ | -------------
reason | String, причина закрытия
discount | размер скидки (в копейках)

В случае, если пользователи договорились о скидке, то в поле Discount указывается размер скидки в копейках.
Сумма из поля Discount будет вычтена из суммы выплаты Продавцу.

*Пример запроса*
```json
POST /orders/30/close
```

*Пример ответа*

```json
{
  "id": 467,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "closed",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
 ```
Сделка завершена `(status: closed)`. Затем на карту продавца (id 180) SafeCrow переведет сумму сделки.

Сообщения об ошибках:
"errors":[ "discount is too big" ] - выплата Продавцу менее 100 рублей


## <a name="close_bus">Закрыть сделку (для юр.лиц)</a>
По факту получения выписки о платеже в сторону Исполнителя, происходит закрытие сделки на стороне Safecrow.

При этом партнеру по [зарегистрированному](#settings) `callback_url` уходит уведомление

*Пример уведомления*

```json
{
  "id": 468,
  "status": "closed"
}
```


## <a name="escalate">Эскалировать сделку/открыть претензию</a>
Если покупатель недоволен качеством товара, сделка передается специалистам SafeCrow - `POST /orders/:order_id/escalate`

Следует указать причину `reason (String)`

Переменные | Данные
------------ | -------------
reason | string

*Пример запроса*
```json
POST /orders/32/escalate

{
  "reason": "Some important reason"
}
```

*Пример ответа*
```json
{
  "id": 467,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "escalated",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```

Сделка переходит в статус `"escalated"`, специалисты сэйфкроу разрешают претензию, после чего сделка закрывается (status: closed) или отменяется (status: canceled)


## <a name="add-attachments">Добавить вложение (Attachments)</a>
Для добавления вложений используется `POST /orders/:order_id/attachments`, а также переменные:

Переменные | Данные
------------ | -------------
type | “text”, “image”
body | ассоциативный массив  1. `“text” (JSON)` - текст вложения 2.`“file”(формат base64)` - зашифрованная картинка `“file_name”` - имя файла c расширением (.ico .jpg .png .pdf)
user_id | id пользователя, от имени которого прикрепляется вложение

*Пример запросов*
Запрос на создание текстового вложения

```json
POST /orders/44/attachments

{
  "type": "text",
  "body": {"text": "there is some text"},
  "user_id": 467
}
```

Запрос на создание .jpg .png вложения
```json
POST /orders/44/attachments

{
  "type": "image",
  "body": {
    "file": "AAABAAEAE...A==",
    "file_name": "File.png"
  },
  "user_id": 467
}
```

Запрос на создание .pdf вложения
```json
POST /orders/44/attachments

{
  "type": "pdf",
  "body": {
    "file": "AAABAAEAE...A==",
    "file_name": "doc.pdf"
  },
  "user_id": 467
}
```

*Пример ответов*
```json
{
  "id": 2,
  "user_id": 467,
  "type": "text",
  "body": "{\"text\":\"there is some text\"}",
  "send_at": "2018-02-26T11:14:15+03:00"
},
{
  "id": 3,
  "user_id": 467,
  "type": "image",
  "body": "{\"file_path\":\"https://dev.safecrow.ru/static/trans_attachments/44/File.png\",\"file_name\":\"File.png\"}",
  "send_at": "2018-02-26T12:01:14+03:00"
},
{
  "id": 4,
  "user_id": 467,
  "type": "pdf",
  "body": "{\"file_path\":\"https://dev.safecrow.ru/static/trans_attachments/44/doc.pdf\",\"file_name\":\"doc.pdf\"}",
  "send_at": "2018-02-26T12:01:14+03:00"
}
```


## <a name="show-attachments">Просмотреть вложения</a>
Для просмотра всех вложений конкретной сделки `GET /orders/:order_id/attachments`

*Пример запроса*

```json
 GET /orders/44/attachments
```

*Пример ответа*

``` json
{
  "id": 2,
  "user_id": 467,
  "type": "text",
  "body": "{\"text\":\"there is some text\"}",
  "send_at": "2018-02-26T11:14:15+03:00"
},
{
  "id": 3,
  "user_id": 467,
  "type": "image",
  "body": "{\"file_path\":\"https://dev.safecrow.ru/static/trans_attachments/44/File.png\",\"file_name\"      :\"File.png\"}",
  "send_at": "2018-02-26T12:01:14+03:00"
},
{
  "id": 4,
  "user_id": 467,
  "type": "pdf",
  "body": "{\"file_path\":\"https://dev.safecrow.ru/static/trans_attachments/44/doc.pdf\",\"file_name\":\"doc.pdf\"}",
  "send_at": "2018-02-26T12:01:14+03:00"
}
```


## <a name="confirm-receive">Подтверждение получения товара (для юр.лиц)</a>
Запрос для подтверждения получения товара - `POST /orders/:id/approve`

Переменные | Данные
-|-
status | 'approved'

*Пример запроса*
```json
POST /orders/37610/approve

{
  "status": "approved"
}
```

*Пример ответа*
```json
{
  "id": 37610,
  "description": "something",
  "price": 1000000,
  "supplier_id": 98921,
  "consumer_id": 98920,
  "status": "paid",
  "created_at": "2019-06-18T14:16:56+03:00",
  "updated_at": "2019-06-18T14:37:21+03:00",
  "consumer_payout_method_id": 2628,
  "supplier_payout_method_id": null,
  "consumer_payout_method_type": "BankAccount",
  "supplier_payout_method_type": "BankAccount",
  "consumer_service_cost": 50000,
  "supplier_service_cost": 50000,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "BankAccount",
  "consumer_payment_method_id": null,
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  },
}
```

**Примечание**: Статус сделки в ответе должен быть paid - `"status": "paid"`.


## <a name="send-docs">Отправка закрывающих документов (для юр.лиц)</a>
Для выплаты продавцу, к сделке должны быть приложены закрывающие документы в формате base64
`POST /orders/:id/closing_docs`

Переменные | Данные
-|-
deal-docs | Товаросопроводительные документы
delivery-docs | Товаротранспортные документы

*Пример запроса*
```json
POST /orders/42/closing_docs

{
  "deal-docs": [
    {"document": "base64", "name": "Товаросопроводительный документ 1"}
  ],
  "delivery-docs": [
    {"document": "base64", "name": "Товаротранспортный документ 1"}
  ]
}
```

*Пример ответа*
```json
[
  {
    "order_id": 37774,
    "user_id": 99033,
    "record_type": "zip",
    "data": {"file_path":"https://staging.safecrow.ru/static/trans_attachments/37774/sdf.zip","file_name":"sdf.zip","doc_type":"deal-docs"},
    "created_at": "2019-09-16T16:20:27+03:00"
  },
  {
    "order_id": 37774,
    "user_id": 99033,
    "record_type": "pdf",
    "data": {"file_path":"https://staging.safecrow.ru/static/trans_attachments/37774/sfg.pdf","file_name":"sfg.pdf","doc_type":"delivery-docs"},
    "created_at": "2019-09-16T16:20:27+03:00"
  }
]
```


## <a name="settings">Настройки</a>
Настроить коллбек url `POST /settings` добавив переменную

Переменные | Данные
------------ | -------------
callback_url | ссылка (String)

Посмотреть настройки `GET /settings`

*Пример запроса*

```json
POST /settings

{
  "callback_url": "https://example.com/callback/url"
}
```
По запросу коллбек приходит GET запросом, с параметрами `status`, `orderId(id сделки + _ + случайное число (11_a43234) )` и `price` для аутентификации запроса используется хедер `X-Auth`

X-Auth содержит `hmac`, который считается следующим образом(callback_url - это полный request к серверу, его следует брать из переменных сервера):
`hmac = OpenSSL::HMAC.hexdigest(‘SHA256’, api_secret, “#{api_key}-#{callback_url}“)`

Пример на php:
` $fullReqUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"`
` $result = hash_hmac("SHA256", $apiKey . "-" . $fullReqUrl, $apiSecret);`


## <a name="errors">Другие ошибки</a>
**`“These aren't the droids you're looking for"`** - неправильный url

**`"Jim! She's gonna blow!\n id is a restricted primary key"`** -  данные нельзя поменять

`"Jim! She's gonna blow!\n Invalid filter expression: (message)` - неправильный тип данных?

`"Jim! She's gonna blow!\n undefined method '/' for \"11\":String"` -  тип данных

### Дополнительные возможности


## <a name="acquiring">Эквайринг за доставку</a>
При [создании сделки](#create) нужно дополнительно передать параметры:

Переменные | Данные
------------ | -------------
delivery_cost | стоимость доставки
delivery_cost_payer | кто оплачивает доставку. consumer, supplier, 50/50.
user_id | id пользователя, от имени которого прикрепляется вложение


После создания, в информации по сделке будут дополнительные поля

Переменные | Данные
------------ | -------------
**Обязательные** | |
supplier_delivery_cost  | стоимость доставки для продавца.Будет вычтена из суммы сделки при выплате продавцу
consumer_delivery_cost | стоимость доставки для покупателя.Будет добавлена к сумме при оплате покупателем
**Второстепенные** | |
consumer_cancellation_cost | штраф при отмене.Может вычитаться из суммы сделки, возвращаемой покупателю при отмене. Может использоваться как оплата обратной доставки при возврате товара,


## <a name="preauth">Преавторизация платежей</a>
Для пользователя процесс преавторизации полностью аналогичен процессу оплаты.
При преавторизации у пользователя на карте блокируются денежные средства, необходимые для оплаты сделки, на срок - 3 дня.
В течение этого срока SafeCrow должен получить подтверждение или отмену преавторизации. На 4-ый день SafeCrow отменяет блокировку денежных средств на карте пользователя.
Для проведения преавторизации используйте запрос:  `POST /orders/:order_id/preauth`

*Пример запроса:*

```json
POST /orders/:order_id/preauth

{
  "redirect_url": "http://example.com/redirect/url"
}
```

Для проведения тестовых оплат используйте тестовые карточки шлюза “MandarinPay”.

При выполнении преавторизации сделка переходит в статус `preauthorized`

Переменные | Данные
------------ | -------------
**Обязательные** | |
order_id  | Id сделки, которая будет оплачена Покупателем (consumer)
redirect_url  | ссылка на страницу, куда будет направлен пользователь после оплаты.


Для оплаты сделки и списания денег с карты покупателя, преавторизованый платеж необходимо подтвердить.

При подтверждении преавторизации происходит списание денег с карты покупателя и сделка переходит в статус `paid`.

*Пример запроса*

```json
POST /orders/:order_id/preauth/confirm

{
  "reason": "Some reason"
}
```

*Пример ответа:*

```json
{
  "id": 30,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "preauthorized",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```

Если сделка не была подтверждена - необходимо произвести отмену преавторизации. Статус сделки при этом меняется на `pending`.

*Пример запроса*

```json
POST /orders/:order_id/preauth/release

{
  "reason": "Some reason"
}
```

*Пример ответа*

```json
{
  "id": 30,
  "description": "something",
  "price": 10000,
  "supplier_id": 98918,
  "consumer_id": 98917,
  "status": "pending",
  "consumer_payout_method_id": null,
  "supplier_payout_method_id": 28198,
  "consumer_payout_method_type": "CreditCard",
  "supplier_payout_method_type": "CreditCard",
  "consumer_service_cost": 500,
  "supplier_service_cost": 500,
  "consumer_delivery_cost": 0,
  "supplier_delivery_cost": 0,
  "consumer_cancellation_cost": 0,
  "discount": 0,
  "consumer_payment_method_type": "CreditCard",
  "consumer_payment_method_id": null,
  "created_at": "2019-06-17T14:35:08+03:00",
  "updated_at": "2019-06-17T16:40:40+03:00",
  "foreign_supplier_payout_method_id": null,
  "foreign_consumer_payout_method_id": null,
  "foreign_supplier_payout_method_type": null,
  "foreign_consumer_payout_method_type": null,
  "foreign_consumer_payment_method_type": null,
  "foreign_consumer_payment_method_id": null,
  "extra": {
  }
}
```
