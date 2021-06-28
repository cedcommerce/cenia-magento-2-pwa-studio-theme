# Magento 2 PWA Studio CENIA THEME By CEDCOMMERCE

We’re happy to share with you our Magento PWA Theme! i.e. Created by our CedCommerce Team, based on PWA Studio Tools and Practices.

![Magento 2 PWA Studio CENIA THEME By CEDCOMMERCE](https://docs.cedcommerce.com/wp-content/uploads/2019/11/section-img-768x281.png)

## Useful links

[Pwa Studio Installation Guide](https://cedcommerce.com/blog/install-magento-pwa-studio/)

[Theme Installation Guide](https://docs.cedcommerce.com/magento-2/pwa-studio-theme-magneto-2/)

## Installation and Licensing

Move the Content of the Folder Ced_PwaApi (pub & app) to Magento 2 Root Directory.

After Successful Moving the file to Magento Root Directory, You need to Run the following Command in Magento Root

`php bin/magento setup:upgrade`

`php bin/magento setup:static-content:deploy`

`php bin/magento setup:di:compile`

In configuration section add license key for the Module 
you can get License from [Link](https://cedcommerce.com/licensing?product_name=magento2_ced_pwaapi/)

After Running These Commands make sure you have NodeJS and Yarn installed in your system.

If not available, you need to install  NodeJS (10.14.1 LTS or above) and Yarn (1.13.0 or Above)

[Process to Install NodeJs](https://docs.cedcommerce.com/magento-2/pwa-studio-theme-magneto-2/?section=nodejs-installation-process/)

[Process to Install Yarn](https://docs.cedcommerce.com/magento-2/pwa-studio-theme-magneto-2/?section=yarn-installation-process/)

Now from the package Downloaded, place pwa_studio folder in parallel of Magento 2 root directory, and run the below  command inside PWA Studio directory

`yarn install`

`yarn buildpack create-custom-origin packages/ced-concept`

Now Navigate to pwa_studio/packages/ced-concept/.env in your Magento and in .env Update your Magento Store URL in place of MAGENTO_BACKEND_URL

Now Run the following command

`yarn run build`

`yarn run stage:ced`

# Learn more

Checkout Pro version of Cenia PWA
https://cedcommerce.com/magento-pwa-studio-theme 

Demo: https://ceniapro.demo.cedcommerce.com/

Watch Cenia Demo 

[![Cenia Demo](https://img.youtube.com/vi/XP9fiyR2byU/0.jpg)](https://www.youtube.com/watch?v=XP9fiyR2byU)




