## FOR SUPPORT PLEASE CONTACT THE FOLLOWING
support@mage365.zendesk.com

## Introduction
This official Zendesk module developed by wagento.

## Support
If you are facing any issue with module installation and configuration please send an email to support@mage365.zendesk.com

## Changelog
Based in `setup_version`

v1.0.17 (composer 220.0.17)
- Resolved warnings that occur during checking Magento coding standards

v1.0.16 (composer 220.0.16)
- Updated admin controller to pass increment id instead of order id in creating ticket

v1.0.15 (composer 220.0.15)
- Created new database table for storing the ticket_id, increment_id, order_id
- Make an entry in this table on placing the order.
- Email support include Guest user tickets
- Shown Magento increment id in zendesk for guest user order
- Shown ticket information in Magento admin panel in Sales >> Orders detail page.

v1.0.14 (composer 220.0.14)
- Support Magento 2.4.3

v1.0.13 (composer 220.0.13)
- Improved multi store configuration

v1.0.12 (composer 220.0.12)
- Added frontcontroller restriction for tickets based in Store > Configurtion > Zendesk > Zendesk Support > Ticket Configuration > Frontend Options
- Fixed item not returned in api call (connection with magento 2 widget for zendesk)
- Fixed php error on admin tickets when credential are note valid

v1.0.11 (composer 220.0.11)
- Restrict API call

v1.0.10 (composer 220.0.10)
- Fixed API date format
- Customer Attributes is synced on ticket creation
- Added websiteurl and store name to ticket attributes

v1.0.9 (composer 220.0.9)
- Updated Zendesk APP installer

v1.0.8 (composer 220.0.8)
- Added reply ticket from admin
- Added enable disable widget fields
- Magento 2.4 support
- php 7.4 support

v1.0.7 (composer 220.0.7)
- Added multi store support, using Api Token only.
- Fixed FLAG on customer sync
- Added phone_number as User attribute

v1.0.6
- Added support for Api Token Authentication for Zendesk API

v1.0.4
- Added support for M2.3
- Fixed template issue when enabling Open Ticket on recent order list
- Added sync customer by cron
- Added callback url information for zendesk API

v1.0.3 Skipped due to issues on MarketPlace release

v1.0.2
- Fixed Customer grid from `Zendesk > Tickets > Create Ticket > Select Customer`.
- Fixed Order grid from `Zendesk > Tickets > Create Ticket > Select Order`.
- Fixed Customer can't see comment box even if "Customer Can Comment In Ticket" is enabled in `System > Zendesk > Zendesk Support > Ticket Configuration > Frontend Options > Customer Can Comment In Ticket`.
- Fixed Zendesk can't open OAuth poup when backend has custom url.
- Improved Order Ticket Field always will be created on zendesk platform and synced to magento store.
- Improved Config Cache clean strategy and clean execution when config is saved to DB.


v1.0.1
- Fixed Authorization problem when user clicks Authorize button in admin
- Improved `App Installation` algorithm, now is smarter and will always update installation infromation.
- Fixed 'Customer Sync' ajax call.
- Fixed Customer Session validation for Ticket Form when magento's cache is enabled.
- Included code improvement from pull request
    - Removed unused dependecies
    - Changed sql select query to load order by customer email


v1.0.0
- Initial module integration for Zendesk
