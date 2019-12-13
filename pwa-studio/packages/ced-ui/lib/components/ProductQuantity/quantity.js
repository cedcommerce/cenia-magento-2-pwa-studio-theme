import React, { useState } from 'react';
import { arrayOf, number, shape, string } from 'prop-types';
import { mergeClasses } from '../../classify';
import defaultClasses from './quantity.css';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faMinus, faPlus } from '@fortawesome/free-solid-svg-icons';

const Quantity = props => {
    const { initialValue, classes: propClasses } = props;
    const classes = mergeClasses(defaultClasses, propClasses);
    const [quantityInstance, setQuantityInstance] = useState(1);

    const handleDecreaseClick = () => {
        if (quantityInstance - 1 < 1) {
            var qty = 1;
        } else {
            var qty = quantityInstance - 1;
        }

        props.onValueChange(qty);
        setQuantityInstance(qty);
    };
    const handleIncreaseClick = () => {
        
        if (quantityInstance + 1 > 100) {
            var qty = 100;
        } else {
            var qty = quantityInstance + 1;
        }
        props.onValueChange(qty);
        setQuantityInstance(qty);
    };

    const handleChange = () => {
        var value = parseInt(document.getElementById('quantity').value);
        const { initialValue } = props;
        if (isNaN(value)) {
            value = initialValue;
        } else if (value < 0) {
            value = 1;
        }
        props.onValueChange(value);
        setQuantityInstance(qty);
    };

    if (quantityInstance < 1) {
        props.onValueChange(initialValue);
        setQuantityInstance(qty);
    }
    return (
        <div className={classes.root}>
            <div className={classes.qty_control_wrap}>
                <div
                    className={classes.qty_control + ' ' + classes.minus}
                    title="Decrease Quantity"
                    priority="high"
                    onClick={handleDecreaseClick}
                >
                    <FontAwesomeIcon icon={faMinus} />
                </div>
                <input
                    type="text"
                    id="quantity"
                    name="quantity"
                    value={quantityInstance}
                    onChange={handleChange}
                />
                <div
                    className={classes.qty_control + ' ' + classes.plus}
                    title="Increase Quantity"
                    priority="high"
                    onClick={handleIncreaseClick}
                >
                    <FontAwesomeIcon icon={faPlus} />
                </div>
            </div>
        </div>
    );
};
Quantity.propTypes = {
    classes: shape({
        root: string
    }),
    items: arrayOf(
        shape({
            value: number
        })
    )
};

Quantity.defaultProps = {
    selectLabel: "product's quantity"
};

export default Quantity;
