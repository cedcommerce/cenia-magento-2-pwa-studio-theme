import React, { useCallback } from 'react';
import { shape, string } from 'prop-types';
import { X as Remove } from 'react-feather';

import { mergeClasses } from '../../../classify';
import Icon from '../../Icon';
import Trigger from '../../Trigger';
import defaultClasses from './currentFilter.css';

const CurrentFilter = props => {
    const { group, groupName, item, removeItem } = props;
    const text = `${groupName}: ${item.title}`;
    const classes = mergeClasses(defaultClasses, props.classes);

    const handleClick = useCallback(() => {
        removeItem({ group, item });
    }, [group, item, removeItem]);

    return (
        <span className={classes.root}>
            <Trigger action={handleClick}>
                <Icon className={classes.icon} size={16} src={Remove} />
            </Trigger>
            <span className={classes.text}>{text}</span>
        </span>
    );
};

export default CurrentFilter;

CurrentFilter.propTypes = {
    classes: shape({
        root: string
    })
};
