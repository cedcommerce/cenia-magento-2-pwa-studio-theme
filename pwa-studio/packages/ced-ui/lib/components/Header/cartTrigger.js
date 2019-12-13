import React from 'react';
import { shape, string } from 'prop-types';
import { ShoppingCart as ShoppingCartIcon } from 'react-feather';

import Icon from '../Icon';

import { mergeClasses } from '../../classify';
import defaultClasses from './cartTrigger.css';
import { useCartTrigger } from '@magento/peregrine/lib/talons/Header/useCartTrigger';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {faShoppingCart} from '@fortawesome/free-solid-svg-icons';

const CART_ICON_FILLED = (
    <Icon
        src={ShoppingCartIcon}
        attrs={{
            fill: 'rgb(var(--venia-text))',
            stroke: 'rgb(var(--venia-text))'
        }}
    />
);
const CART_ICON_EMPTY = (
    <Icon
        src={ShoppingCartIcon}
        attrs={{
            stroke: 'rgb(var(--venia-text))'
        }}
    />
);

const CartTrigger = props => {
    const { handleClick, itemCount } = useCartTrigger();
    const classes = mergeClasses(defaultClasses, props.classes);
    const cartIcon = itemCount > 0 ? CART_ICON_FILLED : CART_ICON_EMPTY;
    const buttonAriaLabel = `Toggle mini cart. You have ${itemCount} items in your cart.`;

    const itemCounter = itemCount ? (
        <span className={classes.counter}>{itemCount}</span>
    ) : 0;

    return (
        <button
            className={classes.root}
            aria-label={buttonAriaLabel}
            onClick={handleClick}
        >
            <div className={classes.mini_cart_detail}>
                <span className={classes.mini_cart_label}>My Cart</span>
                <span> <FontAwesomeIcon icon={faShoppingCart} /></span>
                <span className={classes.cart_counter}>{itemCounter}</span>
            </div>
        </button>
    );
};

CartTrigger.propTypes = {
    classes: shape({
        root: string
    })
};

export default CartTrigger;
