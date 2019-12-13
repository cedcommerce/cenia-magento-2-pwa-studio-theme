import React, { lazy, Suspense } from 'react';
import { Switch, Route } from '@magento/venia-drivers';
import { Page } from '@magento/peregrine';
import ErrorView from '../ErrorView/index';

const Contact = lazy(() => import('../CedHome/contact'));
const CreateAccountPage = lazy(() => import('../CreateAccountPage/index'));
const Search = lazy(() => import('../../RootComponents/Search'));
const Unauthorized = lazy(() => import('../Unauthorized/unauthorized.js'));

const renderRoutingError = props => <ErrorView {...props} />;

const renderRoutes = () => (
    <Suspense fallback={null}>
        <Switch>
            <Route exact path="/search.html" component={Search} />
            <Route exact path="/create-account" component={CreateAccountPage} />
            <Route exact path="/contact-us" component={Contact} />
            <Route exact path="/unauthorized" component={Unauthorized} />
            <Route render={() => <Page>{renderRoutingError}</Page>} />
        </Switch>
    </Suspense>
);

export default renderRoutes;
