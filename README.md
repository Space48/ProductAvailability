# ProductAvailability
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Space48/ProductAvailability/badges/quality-score.png?b=master&s=476c61cd1ed286f2ac73395fca7707df71a9102a)](https://scrutinizer-ci.com/g/Space48/ProductAvailability/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/Space48/ProductAvailability/badges/build.png?b=master&s=a1446cb08e77de2af9af2139b3ae4883483496b8)](https://scrutinizer-ci.com/g/Space48/ProductAvailability/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/Space48/ProductAvailability/badges/coverage.png?b=master&s=2fd9b9164289138870f2f85769ebf80d80e89ec1)](https://scrutinizer-ci.com/g/Space48/ProductAvailability/?branch=master)

Product Availability module for Magento 2

<img width="1228" alt="weathered_oak_clock" src="https://cloud.githubusercontent.com/assets/1080386/24592512/f410d0c4-180f-11e7-856f-a70e19f9ea6c.png">

<img width="1265" alt="products" src="https://cloud.githubusercontent.com/assets/1080386/24808033/5d6ea88e-1bb2-11e7-818e-08de5658540d.png">

## Installation

**Manually** 

To install this module copy the code from this repo to `app/code/Space48/ProductAvailability` folder of your Magento 2 instance, then you need to run php `bin/magento setup:upgrade`

**Via composer**:

From the terminal execute the following:

`composer config repositories.space48-product-availability vcs git@github.com:Space48/ProductAvailability.git`

then

`composer require "space48/productavailability:{release-version}"`

## How to use it
Once installed, go to the `Admin Panel -> Stores -> Configuration -> Space48 -> Product Availability` and `enable` the extension.
