import React, { Fragment, useCallback } from 'react';
import { shape, string } from 'prop-types';

import { Title } from '../../components/Head';
import { mergeClasses } from '../../classify';
import FilterModal from '../../components/FilterModal';
import Gallery from '../../components/Gallery';
import Pagination from '../../components/Pagination';
import defaultClasses from './category.css';
import { useAppContext } from '@magento/peregrine/lib/context/app';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faFilter } from '@fortawesome/free-solid-svg-icons';

// TODO: This can be replaced by the value from `storeConfig when the PR,
// https://github.com/magento/graphql-ce/pull/650, is released.
const pageSize = 6;
const placeholderItems = Array.from({ length: pageSize }).fill(null);

const CategoryContent = props => {
    const [, { toggleDrawer }] = useAppContext();

    const handleOpenFilters = useCallback(() => {
        toggleDrawer('filter');
    }, [toggleDrawer]);

    const { data, pageControl } = props;
    const classes = mergeClasses(defaultClasses, props.classes);
    const filters = data ? data.products.filters : null;
    const items = data ? data.products.items : placeholderItems;
    const title = data ? data.category.name : null;
    const titleContent = title ? `${title} - Venia` : 'Venia';

    const header = filters ? (
        <div className={classes.headerButtons}>
            <button
                className={classes.filterButton}
                onClick={handleOpenFilters}
                type="button"
            >
                <span className={defaultClasses.filter_icon}>
                    <FontAwesomeIcon icon={faFilter} />
                </span>
                {'Filter'}
            </button>
        </div>
    ) : null;

    const modal = filters ? <FilterModal filters={filters} /> : null;
    return (
        <Fragment>
            <Title>{titleContent}</Title>
            <div className="container">
                <div className="row">
                    <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <article className={classes.root}>
                            <div className={defaultClasses.heading_filter}>
                                <h1 className={defaultClasses.title}>
                                    <div
                                        className={defaultClasses.categoryTitle}
                                    >
                                        {title}
                                    </div>
                                </h1>
                                {header}
                            </div>
                            <section className={classes.gallery}>
                                <Gallery items={items} />
                            </section>
                            <div className={classes.pagination}>
                                <Pagination pageControl={pageControl} />
                            </div>
                            {modal}
                        </article>
                    </div>
                </div>
            </div>
        </Fragment>
    );
};

export default CategoryContent;

CategoryContent.propTypes = {
    classes: shape({
        filterContainer: string,
        gallery: string,
        headerButtons: string,
        pagination: string,
        root: string,
        title: string
    })
};
