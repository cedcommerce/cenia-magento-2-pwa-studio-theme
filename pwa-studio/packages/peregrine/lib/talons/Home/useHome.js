import { useEffect, useCallback } from 'react';
import { useQuery } from '@apollo/react-hooks';
import { useCedContext } from '@magento/peregrine/lib/context/ced';
import { Util } from '../..';
/**
 *
 * @param {*} props.query the footer data query
 */
export const useHome = props => {
    const { query } = props;
    const { error, data } = useQuery(query);
    useEffect(() => {
        if (error) {
            console.log('Error fetching Home Page Configurations.');
        }
    }, [error]);

    return {
        HomeConfigData: data && data.homepageConfig.configData
    };
};
export const useGetScopeCache = () => {
    const { BrowserPersistence } = Util;
    const storage = new BrowserPersistence();
    const scopeData = storage.getItem('scope_data');
    return {
        config: scopeData
    };
};
export const useScopeData = props => {
    const { query } = props;
    const { error, data } = useQuery(query, {
        fetchPolicy: 'cache-first',
        errorPolicy: 'all'
    });
    useEffect(() => {
        if (error) {
            console.log(error);
        }
    }, [error]);

    return {
        scopeData: data && data.storeConfig
    };
};

export const useBestSeller = props => {
    const { tquery } = props;
    const { error, data } = useQuery(tquery);
    useEffect(() => {
        if (error) {
            console.log('Error fetching Best Seller data.');
        }
    }, [error]);

    return {
        bestSellerData: data && data.bestSeller.data
    };
};

export const useLatestProducts = props => {
    const { lquery } = props;
    const { error, data } = useQuery(lquery);
    useEffect(() => {
        if (error) {
            console.log('Error fetching Latest Product data.');
        }
    }, [error]);
    return {
        latestProductsData: data && data.latestProducts.data
    };
};

export const useCatIcons = props => {
    const { iconquery, iconIdentifiers } = props;
    const { error, data } = useQuery(iconquery, {
        variables: {
            identifiers: iconIdentifiers
        }
    });
    useEffect(() => {
        if (error) {
            console.log('Error fetching Category icons.');
        }
    }, [error]);

    return {
        catIcons: data && data.cmsBlocks.items[0]['content']
    };
};

export const useCatBanners = props => {
    const { catBannerquery, catBannerIdentifiers } = props;
    const { error, data } = useQuery(catBannerquery, {
        variables: {
            identifiers: catBannerIdentifiers
        }
    });
    useEffect(() => {
        if (error) {
            console.log('Error fetching category banners.');
        }
    }, [error]);

    return {
        catBanners: data && data.cmsBlocks.items[0]['content']
    };
};

export const useOfferBanners = props => {
    const { offerBannerquery, offerBannerIdentifiers } = props;
    const { error, data } = useQuery(offerBannerquery, {
        variables: {
            identifiers: offerBannerIdentifiers
        }
    });
    useEffect(() => {
        if (error) {
            console.log('Error fetching offer banners.');
        }
    }, [error]);

    return {
        offerBanners: data && data.cmsBlocks.items[0]['content']
    };
};

export const useContactUs = props => {
    const [details, { submitContactForm }] = useCedContext();
    const { contactForm } = details;
    const handleSubmit = useCallback(
        async ({ name, email, telephone, comment }) => {
            const payload = {
                name,
                email,
                telephone,
                comment
            };
            try {
                await submitContactForm(payload);
            } catch (error) {
                if (process.env.NODE_ENV === 'development') {
                    console.error(error);
                }
            }
        },
        [submitContactForm]
    );
    if (typeof contactForm != 'undefined')
        document.getElementById('contact-form').reset();
    return {
        handleSubmit,
        responseData: contactForm
    };
};

export const useFooterData = props => {
    const { footerQuery, footerIdentifiers } = props;
    const { error, data } = useQuery(footerQuery, {
        variables: {
            identifiers: footerIdentifiers
        }
    });
    useEffect(() => {
        if (error) {
            console.log('Error fetching footer data.');
        }
    }, [error]);

    return {
        footerData: data && data.cmsBlocks.items[0]['content']
    };
};
