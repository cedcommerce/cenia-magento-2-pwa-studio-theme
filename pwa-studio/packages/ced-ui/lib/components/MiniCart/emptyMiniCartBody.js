import React from 'react';
import { func, string, shape } from 'prop-types';

import { mergeClasses } from '../../classify';
import Trigger from '../Trigger';

import defaultClasses from './emptyMiniCartBody.css';
import { useEmptyMiniCart } from '@magento/peregrine/lib/talons/MiniCart/useEmptyMiniCart';

const EmptyMiniCart = props => {
    const { closeDrawer } = props;

    const talonProps = useEmptyMiniCart({
        closeDrawer
    });

    const { handleClick } = talonProps;

    const classes = mergeClasses(defaultClasses, props.classes);

    return (
        <div className={classes.root}>
            <div className={classes.empty_cart_img}>
                <img
                    src="/venia-static/icons/cedassets/empty_cart/empty_cart.svg"
                    className={defaultClasses.img_fluid}
                    alt=""
                />
            </div>
            <h3 className={classes.emptyTitle}>
                There are no items in your shopping cart
            </h3>
            <Trigger action={handleClick}>
                <span className={classes.continue}>Continue Shopping</span>
            </Trigger>
        </div>
    );
};

EmptyMiniCart.propTypes = {
    classes: shape({
        root: string,
        emptyTitle: string,
        continue: string
    }),
    closeDrawer: func
};

export default EmptyMiniCart;
