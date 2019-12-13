import React, { Suspense } from 'react';
import { arrayOf, bool, number, shape, string } from 'prop-types';
import { Form } from 'informed';
import { Price } from '@magento/peregrine';
import defaultClasses from './productFullDetail.css';
import { mergeClasses } from '../../classify';

import Button from '../Button';
import { fullPageLoadingIndicator } from '../LoadingIndicator';
import Carousel from '../ProductImageCarousel';
import Quantity from '../ProductQuantity';
import RichText from '../RichText';

import { useProductFullDetail } from '@magento/peregrine/lib/talons/ProductFullDetail/useProductFullDetail';
import { isProductConfigurable } from '@magento/peregrine/lib/util/isProductConfigurable';

const Options = React.lazy(() => import('../ProductOptions'));

const ProductFullDetail = props => {
    const { product } = props;

    const talonProps = useProductFullDetail({
        product
    });

    const {
        handleAddToCart,
        handleSelectionChange,
        handleSetQuantity,
        isAddToCartDisabled,
        mediaGalleryEntries,
        productDetails,
        quantity,
        isAddingItem
    } = talonProps;

    const modalClass = isAddToCartDisabled
        ? defaultClasses.modal + ' ' + defaultClasses.modal_active
        : defaultClasses.modal;

    const classes = mergeClasses(defaultClasses, props.classes);

    const options = isProductConfigurable(product) ? (
        <Suspense fallback={fullPageLoadingIndicator}>
            <Options
                onSelectionChange={handleSelectionChange}
                options={product.configurable_options}
            />
        </Suspense>
    ) : null;

    return (
        <div className="container">
            <div className="row">
                <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div className={classes.root_inner}>
                        <Form className={classes.root}>
                            <div className={classes.product_details_right}>
                                <section className={classes.title}>
                                    <h1 className={classes.productName}>
                                        {product.name}
                                    </h1>
                                    <p className={classes.productPrice}>
                                        <Price
                                            currencyCode={
                                                productDetails.price.currency
                                            }
                                            value={productDetails.price.value}
                                        />
                                    </p>
                                </section>
                                <section
                                    className={
                                        classes.details +
                                        ' ' +
                                        classes.sku_details
                                    }
                                >
                                    <h2 className={classes.detailsTitle}>
                                        SKU
                                    </h2>
                                    <strong className={classes.sku}>
                                        {product.sku}
                                    </strong>
                                </section>
                                <section className={classes.options}>
                                    {options}
                                </section>
                                <section className={classes.quantity}>
                                    <h2 className={classes.quantityTitle}>
                                        Quantity
                                    </h2>
                                    <Quantity
                                        initialValue={quantity}
                                        onValueChange={handleSetQuantity}
                                    />
                                </section>

                                <section className={classes.cartActions}>
                                    <div
                                        className={
                                            defaultClasses.loader_case_wrapp
                                        }
                                    >
                                        <Button
                                            priority="high"
                                            onClick={handleAddToCart}
                                            disabled={isAddToCartDisabled}
                                        >
                                            Add to Cart
                                        </Button>
                                        <React.Fragment>
                                            {isAddingItem && (
                                                <div className={modalClass}>
                                                    <div
                                                        className={
                                                            defaultClasses.loader_div
                                                        }
                                                    >
                                                        <div
                                                            className={
                                                                defaultClasses.ball_pulse
                                                            }
                                                        >
                                                            <div />
                                                            <div />
                                                            <div />
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                        </React.Fragment>
                                    </div>
                                </section>
                            </div>

                            <section className={classes.imageCarousel}>
                                <Carousel images={mediaGalleryEntries} />
                            </section>
                            <section className={classes.description}>
                                <h2 className={classes.descriptionTitle}>
                                    Product Description
                                </h2>
                                <RichText content={product.description} />
                            </section>
                        </Form>
                    </div>
                </div>
            </div>
        </div>
    );
};

ProductFullDetail.propTypes = {
    classes: shape({
        cartActions: string,
        description: string,
        descriptionTitle: string,
        details: string,
        detailsTitle: string,
        imageCarousel: string,
        options: string,
        productName: string,
        productPrice: string,
        quantity: string,
        quantityTitle: string,
        root: string,
        title: string
    }),
    product: shape({
        __typename: string,
        id: number,
        sku: string.isRequired,
        price: shape({
            regularPrice: shape({
                amount: shape({
                    currency: string.isRequired,
                    value: number.isRequired
                })
            }).isRequired
        }).isRequired,
        media_gallery_entries: arrayOf(
            shape({
                label: string,
                position: number,
                disabled: bool,
                file: string.isRequired
            })
        ),
        description: string
    }).isRequired
};

export default ProductFullDetail;
