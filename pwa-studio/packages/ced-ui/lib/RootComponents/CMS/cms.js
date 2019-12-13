import React from 'react';
import { useQuery } from '@apollo/react-hooks';
import cmsPageQuery from '../../queries/getCmsPage.graphql';
import { fullPageLoadingIndicator } from '../../components/LoadingIndicator';
import RichContent from '../../components/RichContent';
import { number } from 'prop-types';
import CedHome from '../../components/CedHome/home';
import GET_HOMEPAGECONFIG_DATA from '@magento/ced-ui/lib/queries/getHomeConfig.graphql';
import { useHome } from '@magento/peregrine/lib/talons/Home/useHome';

const CMSPage = props => {
    const { id } = props;
    const { loading, error, data } = useQuery(cmsPageQuery, {
        variables: {
            id: Number(id),
            onServer: false
        }
    });
    const homepageData = useHome({
        query: GET_HOMEPAGECONFIG_DATA
    });

    const { HomeConfigData } = homepageData;

    if (error) {
        if (process.env.NODE_ENV !== 'production') {
            console.error(error);
        }
        return <div>Page Fetch Error</div>;
    }

    if (loading) {
        return fullPageLoadingIndicator;
    }

    if (data) {
        // Only render <RichContent /> if the page isn't empty and doesn't contain the default CMS Page text.
        if (
            data.cmsPage.content &&
            data.cmsPage.content.length > 0 &&
            !data.cmsPage.content.includes('CMS homepage content goes here.')
        ) {
            return <RichContent html={data.cmsPage.content} />;
        }
        if (typeof HomeConfigData != 'undefined') {
            return (
                <div>
                    <CedHome HomepageConfig={HomeConfigData} />
                </div>
            );
        }

        return null;
    }
    return null;
};

CMSPage.propTypes = {
    id: number
};

export default CMSPage;
