import React from 'react';

import AppContextProvider from '../context/app';
import CartContextProvider from '../context/cart';
import CatalogContextProvider from '../context/catalog';
import CheckoutContextProvider from '../context/checkout';
import ErrorContextProvider from '../context/unhandledErrors';
import UserContextProvider from '../context/user';
import CedContextProvider from '../context/ced';
/**
 * List of essential context providers that are required to run Peregrine
 *
 * @property {React.Component[]} contextProviders
 */
const contextProviders = [
    ErrorContextProvider,
    AppContextProvider,
    UserContextProvider,
    CatalogContextProvider,
    CartContextProvider,
    CheckoutContextProvider,
    CedContextProvider
];

const PeregrineContextProvider = ({ children }) => {
    return contextProviders.reduceRight((memo, ContextProvider) => {
        return <ContextProvider>{memo}</ContextProvider>;
    }, children);
};

export default PeregrineContextProvider;
