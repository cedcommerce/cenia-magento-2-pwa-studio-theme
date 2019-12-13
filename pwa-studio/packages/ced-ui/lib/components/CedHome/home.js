import React from 'react';
import { shape, string } from 'prop-types';
import RichContent from '../../components/RichContent';
import { mergeClasses } from '../../classify';
import defaultClasses from './home.css';
import { useSlider } from '@magento/peregrine/lib/talons/Slider/useSlider';
import {
    useBestSeller,
    useLatestProducts,
    useCatIcons,
    useCatBanners,
    useOfferBanners
} from '@magento/peregrine/lib/talons/Home/useHome';
import GET_SLIDER_DATA from '@magento/ced-ui/lib/queries/getSliderDetails.graphql';

import GET_BESTSELLER_DATA from '@magento/ced-ui/lib/queries/getBestSeller.graphql';
import GET_LATESTPRODUCTS_DATA from '@magento/ced-ui/lib/queries/getLatestProducts.graphql';
import { Link, resourceUrl } from 'src/drivers';
import OwlCarousel from 'react-owl-carousel';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.css';

import GET_CMSBLOCK_QUERY from '../../queries/getCmsBlocks.graphql';

const Home = props => {
    const classes = mergeClasses(defaultClasses, props.classes);
    const talonProps = useSlider({
        query: GET_SLIDER_DATA
    });
    const responsive1 = {
        0: {
            items: 1
        },
        450: {
            items: 2
        },
        600: {
            items: 3
        },
        1000: {
            items: 4
        }
    };

    const bestSellerDatas = useBestSeller({
        tquery: GET_BESTSELLER_DATA
    });

    const latestProductsDatas = useLatestProducts({
        lquery: GET_LATESTPRODUCTS_DATA
    });

    const { sliderData } = talonProps;

    
    const { bestSellerData } = bestSellerDatas;
    const { latestProductsData } = latestProductsDatas;

    const { HomepageConfig } = props;
    let showCategoryIcons = false;
    let showCategoryBanners = false;
    let showOfferBanners = false;
    let showHomeSlider = false;
    for (var i = 0; i < HomepageConfig.length; i++) {
        if (HomepageConfig[i]['name'] == 'categories_icon_block')
            var catIconIdentifier = HomepageConfig[i]['value'];
        if (HomepageConfig[i]['name'] == 'categories_banner_block')
            var categoryBannerIdentifier = HomepageConfig[i]['value'];
        if (HomepageConfig[i]['name'] == 'offer_banner_block')
            var offerBannersIdentifier = HomepageConfig[i]['value'];
        if (HomepageConfig[i]['name'] == 'show_trending_products')
            var showTrendingProducts = parseInt(HomepageConfig[i]['value']);
        if (HomepageConfig[i]['name'] == 'show_latest_products')
            var showLatestProducts = parseInt(HomepageConfig[i]['value']);
        if (HomepageConfig[i]['name'] == 'show_category_icon')
            showCategoryIcons = parseInt(HomepageConfig[i]['value']);
        if (HomepageConfig[i]['name'] == 'show_category_banner')
            showCategoryBanners = parseInt(HomepageConfig[i]['value']);
        if (HomepageConfig[i]['name'] == 'show_offer_banner')
            showOfferBanners = parseInt(HomepageConfig[i]['value']); 
        if (HomepageConfig[i]['name'] == 'show_home_slider')
            showHomeSlider = parseInt(HomepageConfig[i]['value']);     
    }

    const catIconDatas = useCatIcons({
        iconquery: GET_CMSBLOCK_QUERY,
        iconIdentifiers: catIconIdentifier
    });

    const catBannerDatas = useCatBanners({
        catBannerquery: GET_CMSBLOCK_QUERY,
        catBannerIdentifiers: categoryBannerIdentifier
    });

    const offerBannerDatas = useOfferBanners({
        offerBannerquery: GET_CMSBLOCK_QUERY,
        offerBannerIdentifiers: offerBannersIdentifier
    });

    const { catIcons } = catIconDatas;
    const { catBanners } = catBannerDatas;
    const { offerBanners } = offerBannerDatas;

    let categoryIcons = '';
    if (catIcons) {
        categoryIcons = catIcons;
    }
    let categoryBanners = '';
    if (catBanners) {
        categoryBanners = catBanners;
    }
    let offerBannerstext = '';
    if (offerBanners) {
        offerBannerstext = offerBanners;
    }
   
    // const elements = JSON.parse(getHomesliderDetails).urls;
    return (
        <React.Fragment>
            <div>
                {showHomeSlider != 0 && typeof sliderData != 'undefined' && (
                    <div className={classes.section_banner}>
                        <div
                            id="scroll"
                            className="carousel slide"
                            data-ride="carousel"
                        >
                            <ol className="carousel-indicators">
                                {sliderData.allSlides.map((value, index) => {
                                    var className = '';
                                    if (index == 0) {
                                        className = 'active';
                                    }
                                    return (
                                        <li
                                            key={index}
                                            data-target="#scroll"
                                            data-slide-to={index}
                                            className={className}
                                        />
                                    );
                                })}
                            </ol>
                            <div className="carousel-inner">
                                {sliderData.allSlides.map(
                                    (value, index, ClassDetails, imgname) => {
                                        var imgname = value.image
                                            .split('/')
                                            .pop();
                                        var image = resourceUrl(value.image, {
                                            type: 'image-custom',
                                            width: 1400
                                        });

                                        if (index == 0) {
                                            ClassDetails =
                                                'carousel-item active';
                                        } else {
                                            ClassDetails = 'carousel-item';
                                        }
                                        let url = "/";
                                        if(value.url){
                                            url = value.url;
                                        }
                                        return (
                                            <div
                                                key={index}
                                                className={ClassDetails}
                                            >
                                                <Link
                                                    to={resourceUrl(url)}
                                                >
                                                    <img
                                                        className={'img-fluid'}
                                                        src={image}
                                                        alt={imgname}
                                                    />
                                                </Link>
                                            </div>
                                        );
                                    }
                                )}
                            </div>
                            <a
                                className="carousel-control-prev"
                                href="#scroll"
                                role="button"
                                data-slide="prev"
                            >
                                <span aria-label="Previous">‹</span>
                            </a>
                            <a
                                className="carousel-control-next"
                                href="#scroll"
                                role="button"
                                data-slide="next"
                            >
                                <span aria-label="Next">›</span>
                            </a>
                        </div>
                    </div>
                )}
                {showCategoryIcons != 0 && (
                    <div className={classes.section_line_icons}>
                        <RichContent html={categoryIcons} />
                    </div>
                )}
                {/* Trending product section  */}
                {showTrendingProducts != 0 && (
                    <section
                        className={
                            defaultClasses.h_products +
                            ' ' +
                            defaultClasses.section
                        }
                    >
                        <div className="container">
                            <div className="row">
                                <div className="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                                    <div
                                        className={
                                            defaultClasses.section_heading
                                        }
                                    >
                                        <h3
                                            className={
                                                defaultClasses.section_title
                                            }
                                        >
                                            Trending product
                                        </h3>
                                        <p
                                            className={
                                                defaultClasses.section_content
                                            }
                                        >
                                            Lorem ipsum dolor sit amet,
                                            consectetur adipisicing elit, sed do
                                            eiusmod tempor incididunt ut labore
                                            et dolore magna aliqua.
                                        </p>
                                    </div>
                                    {/* item div will loop for more item 
                             note: here will be implemted owl slider
                         */}

                                    <React.Fragment>
                                        {bestSellerData && typeof bestSellerData !=
                                            'undefined' && (
                                            <OwlCarousel
                                                className={
                                                    'owl-theme' +
                                                    ' ' +
                                                    defaultClasses.owl_thme_design
                                                }
                                                loop={true}
                                                margin={10}
                                                nav={true}
                                                dots={false}
                                                autoplay={true}
                                                autoplayTimeout={2000}
                                                items={4}
                                                responsive={responsive1}
                                            >
                                                {bestSellerData.map(
                                                    (value, index) => {
                                                        var image = resourceUrl(
                                                            value['image'],
                                                            {
                                                                type:
                                                                    'image-product',
                                                                width: 300
                                                            }
                                                        );
                                                        var description =
                                                            value.description;
                                                        var description = description.replace(
                                                            /<[^>]+>/g,
                                                            ''
                                                        );
                                                        return (
                                                            <div
                                                                key={index}
                                                                className="item"
                                                            >
                                                                <div
                                                                    className={
                                                                        defaultClasses.products_grid_item
                                                                    }
                                                                >
                                                                    <div
                                                                        className={
                                                                            defaultClasses.noo_product_item
                                                                        }
                                                                    >
                                                                        <div
                                                                            className={
                                                                                defaultClasses.noo_product_inner
                                                                            }
                                                                        >
                                                                            <div
                                                                                className={
                                                                                    defaultClasses.noo_product_image
                                                                                }
                                                                            >
                                                                                <Link
                                                                                    to={resourceUrl(
                                                                                        value[
                                                                                            'urlkey'
                                                                                        ]
                                                                                    )}
                                                                                >
                                                                                    <img
                                                                                        src={
                                                                                            image
                                                                                        }
                                                                                        alt=""
                                                                                        className="product_image"
                                                                                    />
                                                                                </Link>
                                                                            </div>
                                                                            <div
                                                                                className={
                                                                                    defaultClasses.noo_details_wrapper
                                                                                }
                                                                            >
                                                                                <h3
                                                                                    className={
                                                                                        defaultClasses.product_name
                                                                                    }
                                                                                >
                                                                                    <Link
                                                                                        to={resourceUrl(
                                                                                            value[
                                                                                                'urlkey'
                                                                                            ]
                                                                                        )}
                                                                                    >
                                                                                        {
                                                                                            value.name
                                                                                        }
                                                                                    </Link>
                                                                                </h3>
                                                                                <p
                                                                                    className={
                                                                                        defaultClasses.product_description
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        description
                                                                                    }
                                                                                </p>
                                                                                <div
                                                                                    className={
                                                                                        defaultClasses.price_wrapp
                                                                                    }
                                                                                >
                                                                                    <span
                                                                                        className={
                                                                                            defaultClasses.price
                                                                                        }
                                                                                    >
                                                                                        {
                                                                                            value.price
                                                                                        }
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        );
                                                    }
                                                )}
                                            </OwlCarousel>
                                        )}
                                    </React.Fragment>
                                    {/* end
                                     */}
                                </div>
                            </div>
                        </div>
                    </section>
                )}
                {/* Trending product section end */}
                {/* Static block section start */}
                {showCategoryBanners != 0 && (
                    <section className={
                        defaultClasses.section +
                        ' ' +
                        defaultClasses.static_blocks
                    }
                >
                    <RichContent html={categoryBanners} />
                </section>

                )}
                
                {/* Static block section END */}
                {/* Latest product section */}
                {showLatestProducts != 0 && (
                    <section
                        className={
                            defaultClasses.h_products +
                            ' ' +
                            defaultClasses.section
                        }
                    >
                        <div className="container">
                            <div className="row">
                                <div className="col-xs-12 col-lg-12 col-sm-12 col-md-12">
                                    <div
                                        className={
                                            defaultClasses.section_heading
                                        }
                                    >
                                        <h3
                                            className={
                                                defaultClasses.section_title
                                            }
                                        >
                                            Latest product
                                        </h3>
                                        <p
                                            className={
                                                defaultClasses.section_content
                                            }
                                        >
                                            Lorem ipsum dolor sit amet,
                                            consectetur adipisicing elit, sed do
                                            eiusmod tempor incididunt ut labore
                                            et dolore magna aliqua.
                                        </p>
                                    </div>
                                    <React.Fragment>
                                        {latestProductsData && typeof latestProductsData !=
                                            'undefined' && (
                                            <OwlCarousel
                                                className={
                                                    'owl-theme' +
                                                    ' ' +
                                                    defaultClasses.owl_thme_design
                                                }
                                                loop={true}
                                                margin={10}
                                                nav={true}
                                                dots={false}
                                                autoplay={true}
                                                autoplayTimeout={2000}
                                                items={4}
                                                responsive={responsive1}
                                            >
                                                {latestProductsData.map(
                                                    (value, index) => {
                                                        var image = resourceUrl(
                                                            value['image'],
                                                            {
                                                                type:
                                                                    'image-product',
                                                                width: 300
                                                            }
                                                        );
                                                        var description =
                                                            value.description;
                                                        var description = description.replace(
                                                            /<[^>]+>/g,
                                                            ''
                                                        );
                                                        return (
                                                            <div
                                                                key={index}
                                                                className="item"
                                                            >
                                                                <div
                                                                    className={
                                                                        defaultClasses.products_grid_item
                                                                    }
                                                                >
                                                                    <div
                                                                        className={
                                                                            defaultClasses.noo_product_item
                                                                        }
                                                                    >
                                                                        <div
                                                                            className={
                                                                                defaultClasses.noo_product_inner
                                                                            }
                                                                        >
                                                                            <div
                                                                                className={
                                                                                    defaultClasses.noo_product_image
                                                                                }
                                                                            >
                                                                                <Link
                                                                                    to={resourceUrl(
                                                                                        value[
                                                                                            'urlkey'
                                                                                        ]
                                                                                    )}
                                                                                >
                                                                                    <img
                                                                                        src={
                                                                                            image
                                                                                        }
                                                                                        alt=""
                                                                                        className="product_image"
                                                                                    />
                                                                                </Link>
                                                                            </div>
                                                                            <div
                                                                                className={
                                                                                    defaultClasses.noo_details_wrapper
                                                                                }
                                                                            >
                                                                                <h3
                                                                                    className={
                                                                                        defaultClasses.product_name
                                                                                    }
                                                                                >
                                                                                    <Link
                                                                                        to={resourceUrl(
                                                                                            value[
                                                                                                'urlkey'
                                                                                            ]
                                                                                        )}
                                                                                    >
                                                                                        {
                                                                                            value.name
                                                                                        }
                                                                                    </Link>
                                                                                </h3>
                                                                                <p
                                                                                    className={
                                                                                        defaultClasses.product_description
                                                                                    }
                                                                                >
                                                                                    {
                                                                                        description
                                                                                    }
                                                                                </p>
                                                                                <div
                                                                                    className={
                                                                                        defaultClasses.price_wrapp
                                                                                    }
                                                                                >
                                                                                    <span
                                                                                        className={
                                                                                            defaultClasses.price
                                                                                        }
                                                                                    >
                                                                                        {
                                                                                            value.price
                                                                                        }
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        );
                                                    }
                                                )}
                                            </OwlCarousel>
                                        )}
                                    </React.Fragment>
                                </div>
                            </div>
                        </div>
                    </section>
                )}
                {/* Latest product section end */}

                {/* two col block */}
                {showOfferBanners != 0 && (
                    <section
                    className={
                        defaultClasses.section +
                        ' ' +
                        defaultClasses.static_blocks
                    }
                >
                    <RichContent html={offerBannerstext} />
                </section>

                )}
                
                {/* two col block end */}
            </div>
        </React.Fragment>
    );
};

Home.propTypes = {
    classes: shape({
        copyright: string,
        root: string,
        tile: string,
        tileBody: string,
        tileTitle: string
    })
};

export default Home;
