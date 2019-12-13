import React from 'react';
import { shape, string } from 'prop-types';
import { useFooter } from '@magento/peregrine/lib/talons/Footer/useFooter';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import RichContent from '../../components/RichContent';
import {useFooterData } from '@magento/peregrine/lib/talons/Home/useHome';
import { faArrowUp } from '@fortawesome/free-solid-svg-icons';

import { mergeClasses } from '../../classify';
import defaultClasses from './footer.css';

import NewsLetter from '../NewsLetter';
import GET_STORE_CONFIG_DATA from '../../queries/getStoreConfigData.graphql';
import $ from 'jquery';

import GET_CMSBLOCK_QUERY from '../../queries/getCmsBlocks.graphql';

const Footer = props => {
    const classes = mergeClasses(defaultClasses, props.classes);

    const talonProps = useFooter({
        query: GET_STORE_CONFIG_DATA
    });
    const { copyrightText } = talonProps;

    let copyright = null;
    if (copyrightText) {
        copyright = <span>{copyrightText}</span>;
    }

    const scrollTop = () => window.scrollTo(0, 0);
    $('.mobile_acco').click(function(){
        alert('dfsdsfsdf');
    });
    


    const openTabs = e => {
        alert('dfsdsfsdffffffffff');
        $(e.target)
            .parent()
            .siblings('.mobile_acco')
            .slideToggle();
        $(e.target).toggleClass(defaultClasses.active);
    };

    const footerDatas = useFooterData({
        footerQuery: GET_CMSBLOCK_QUERY,
        footerIdentifiers: 'ced-pwa-footer'
    });
    const { footerData } = footerDatas;
    
    return (
        <footer className={defaultClasses.main_footer}>
            <div className={defaultClasses.newsletter}>
                <div className="container">
                    <div className="row">
                        <div
                            className={
                                'col-lg-12' +
                                ' ' +
                                'col-md-12' +
                                ' ' +
                                'col-sm-12' +
                                ' ' +
                                'col-xs-12'
                            }
                        >
                            <NewsLetter />
                        </div>
                    </div>
                </div>
            </div>
            
            <RichContent html={footerData} />

            <div className={defaultClasses.footer_copyright}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <address className={defaultClasses.copyright}>
                                {copyright}
                            </address>
                        </div>
                    </div>
                </div>
            </div>
            <div className={defaultClasses.scroll_to_top}>
                <div onClick={scrollTop}>
                    <FontAwesomeIcon icon={faArrowUp} />
                </div>
            </div>
        </footer>
    );
};


Footer.propTypes = {
    classes: shape({
        copyright: string,
        root: string,
        tile: string,
        tileBody: string,
        tileTitle: string
    })
};

export default Footer;
