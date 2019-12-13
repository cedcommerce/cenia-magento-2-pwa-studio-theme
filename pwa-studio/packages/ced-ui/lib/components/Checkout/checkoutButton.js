import React from 'react';
import { bool, func } from 'prop-types';

import Button from '../Button';
import Icon from '../Icon';
import { Lock as LockIcon } from 'react-feather';

const CheckoutButton = ({ disabled, onClick }) => {
    return (
        <div>
            <Button priority="high" disabled={disabled} onClick={onClick}>
                <Icon src={LockIcon} size={16} />
                <span>Checkout</span>
            </Button>
            
        </div>
    );
};

CheckoutButton.propTypes = {
    disabled: bool,
    onClick: func
};

export default CheckoutButton;
