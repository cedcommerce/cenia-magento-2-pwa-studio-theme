import React from 'react';
import { shape, string } from 'prop-types';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import GET_HOMEPAGECONFIG_DATA from '@magento/ced-ui/lib/queries/getHomeConfig.graphql';
import { useHome } from '@magento/peregrine/lib/talons/Home/useHome';
import Button from '../Button';
import {
    faBaseballBall,
    faChevronDown,
    faEnvelope
} from '@fortawesome/free-solid-svg-icons';
import {
    faTwitter,
    faFacebookSquare,
    faGooglePlusG,
    faPinterest
} from '@fortawesome/free-brands-svg-icons';
import $ from 'jquery';
import Logo from '../Logo';
import Icon from '../Icon';
import MenuIcon from 'react-feather/dist/icons/menu';
import { Link, resourceUrl, Route, Redirect } from '@magento/venia-drivers';

import CartTrigger from './cartTrigger';
import NavTrigger from './navTrigger';
import {
    useHeader,
    useNavigation
} from '@magento/peregrine/lib/talons/Header/useHeader';

import { mergeClasses } from '../../classify';
import defaultClasses from './header.css';
import SearchBar from '../SearchBar';
import MobileLogo from '../MobileLogo';

const Header = props => {
    const { handleSignOut,isSignedIn } = useHeader();

    const talonsProps = useNavigation();
    const { navdetails } = talonsProps;

    const classes = mergeClasses(defaultClasses, props.classes);
    const navItems = [];
    const homepageData = useHome({
        query: GET_HOMEPAGECONFIG_DATA
    });

    const { HomeConfigData } = homepageData;
   
    let licenseValidate = "";
    let supportEmail = "";
    if(typeof HomeConfigData != "undefined" ){
        for (var i = 0; i < HomeConfigData.length; i++) {
            if (HomeConfigData[i]['name'] == 'email')
               supportEmail = HomeConfigData[i]['value'];
            if (HomeConfigData[i]['name'] == 'license'){
                licenseValidate = HomeConfigData[i]['value'];
            }
               
        }
    } 
    
    if(licenseValidate !=""){
        localStorage.setItem('ced_license',licenseValidate);
    }

    if(licenseValidate == "novalue"){
        return <Redirect to="/unauthorized" />;
    }
  
    if (typeof navdetails != "undefined" && navdetails) {
        const elements = JSON.parse(navdetails).categories;
        if(elements){
            $.each(elements, function(i, v) {
                if (v['main_category_id']) {
                    if (
                        typeof v['sub_cats'] != 'undefined' &&
                        v['sub_cats'].length
                    ) {
                        var haschild = defaultClasses.has_child;
                    } else {
                        var haschild = '';
                    }
                    navItems.push(
                        <li
                            key={i}
                            className={defaultClasses.item + ' ' + haschild}
                        >
                            <Link to={resourceUrl('/' + v['main_category_url'])}>
                                {v['main_category_name']}
                                {haschild && (
                                    <FontAwesomeIcon icon={faChevronDown} />
                                )}
                            </Link>
                            <ul key={i+"mainul"}
                                className={
                                    defaultClasses.sub_menu +
                                    ' ' +
                                    defaultClasses.lavel_1
                                }
                            >
                                {typeof v['sub_cats'] != 'undefined' &&
                                    v['sub_cats'].map((v1, i1) => {
                                        if (v1['sub_cats'].length) {
                                            var showsubchild = true;
                                            var hasSubchild =
                                                defaultClasses.has_child;
                                        } else {
                                            var hasSubchild = '';
                                            var showsubchild = false;
                                        }
                                        return (
                                            <React.Fragment>
                                                <li
                                                    key={i1 + 'sub'}
                                                    className={hasSubchild}
                                                >
                                                    <Link
                                                        to={resourceUrl(
                                                            '/' +
                                                                v1[
                                                                    'sub_category_url'
                                                                ]
                                                        )}
                                                    >
                                                        {v1['sub_category_name']}
                                                        {showsubchild && (
                                                            <FontAwesomeIcon
                                                                icon={faChevronDown}
                                                            />
                                                        )}
                                                    </Link>
                                                    {showsubchild && (
                                                        <ul
                                                            className={
                                                                defaultClasses.sub_menu +
                                                                ' ' +
                                                                defaultClasses.lavel_2
                                                            }
                                                        >
                                                            {v1['sub_cats'].map(
                                                                (v2, i2) => {
                                                                    return (
                                                                        <li
                                                                            key={
                                                                                i2 +
                                                                                'supersub'
                                                                            }
                                                                        >
                                                                            <Link
                                                                                to={resourceUrl(
                                                                                    '/' +
                                                                                        v2[
                                                                                            'category_url'
                                                                                        ]
                                                                                )}
                                                                            >
                                                                                {
                                                                                    v2[
                                                                                        'category_name'
                                                                                    ]
                                                                                }
                                                                            </Link>
                                                                        </li>
                                                                    );
                                                                }
                                                            )}
                                                        </ul>
                                                    )}
                                                </li>
                                            </React.Fragment>
                                        );
                                    })}
                            </ul>
                        </li>
                    );
                }
            });
        }
        
    }
   
    if(licenseValidate) {
    return (
        <header id="header" className={defaultClasses.main_header}>
            {/* section-upper-header  */}
            <div className={defaultClasses.section_header_top}>
                <div className="container">
                    <div className="row">
                        <div className="col-6 text_left">
                            <div className={defaultClasses.social_icon}>
                                <ul className={defaultClasses.social}>
                                    <li className={defaultClasses.item}>
                                        <Link to="/" title="Twitter">
                                            <FontAwesomeIcon icon={faTwitter} />
                                        </Link>
                                    </li>
                                    <li className={defaultClasses.item}>
                                        <Link to="/" title="Facebook">
                                            <FontAwesomeIcon
                                                icon={faFacebookSquare}
                                            />
                                        </Link>
                                    </li>
                                    <li className={defaultClasses.item}>
                                        <Link to="/" title="Google">
                                            <FontAwesomeIcon
                                                icon={faGooglePlusG}
                                            />
                                        </Link>
                                    </li>
                                    <li className={defaultClasses.item}>
                                        <Link to="/" title="Pinterest">
                                            <FontAwesomeIcon
                                                icon={faPinterest}
                                            />
                                        </Link>
                                    </li>
                                    <li className={defaultClasses.item}>
                                        <Link to="/" title="Twitter">
                                            <FontAwesomeIcon
                                                icon={faBaseballBall}
                                            />
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div
                            className={
                                defaultClasses.text_right + ' ' + 'col-6'
                            }
                        >
                            <div className={defaultClasses.header_contact}>
                                <a href="mailto:support@cedcommerce.com?Subject=Hello%20again">
                                    <FontAwesomeIcon icon={faEnvelope} />
                                    <span
                                        className={defaultClasses.contact_span}
                                    >
                                        {supportEmail}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* End of section-upper-header  */}
            {/* section-upper-header  */}
            <div className={defaultClasses.section_middle_header + ' '}>
                <div className="container">
                    <div className="row">
                        <div
                            className={
                                'col-lg-2 col-md-2' +
                                ' ' +
                                defaultClasses.logoLinkWrapper
                            }
                        >
                            {
                                <div className={defaultClasses.navtoggle}>
                                    <NavTrigger>
                                        <Icon src={MenuIcon} />
                                    </NavTrigger>
                                </div>
                            }
                            <Link
                                className={
                                    defaultClasses.logoLink +
                                    ' ' +
                                    defaultClasses.desktopLogo
                                }
                                to={resourceUrl('/')}
                            >
                                <Logo className={defaultClasses.root} />
                            </Link>

                            <Link
                                className={
                                    defaultClasses.logoLink +
                                    ' ' +
                                    defaultClasses.mobileLogo
                                }
                                to={resourceUrl('/')}
                            >
                                <MobileLogo className={defaultClasses.root} />
                            </Link>
                        </div>
                        <div
                            className={
                                'col-lg-7 col-md-6' +
                                ' ' +
                                defaultClasses.siteSearchWrapper
                            }
                        >
                            <div className={defaultClasses.search_site}>
                                {
                                    <Route
                                        render={({ history, location }) => (
                                            <SearchBar
                                                history={history}
                                                location={location}
                                            />
                                        )}
                                    />
                                }
                            </div>
                        </div>
                        <div
                            className={
                                'col-lg-3 col-md-4' +
                                ' ' +
                                defaultClasses.siteOtherLinks
                            }
                        >
                            <div className={defaultClasses.cart_link}>
                                <CartTrigger />
                            </div>
                            <div className={defaultClasses.cedDropDown}>
                                <ul className={defaultClasses.DropDownList}>
                                    <li
                                        className={defaultClasses.DropDownWrapp}
                                    >
                                        <React.Fragment>
                                            {isSignedIn && (
                                                 <Button className={defaultClasses.signout_btn} onClick={handleSignOut}>{"Sign Out"}</Button>
                                            )}
                                            {!isSignedIn && (
                                                <span>
                                                    <NavTrigger>
                                                        Login/Signup
                                                    </NavTrigger>
                                                </span>
                                            )}
                                        </React.Fragment>
                                    </li>
                                    <li
                                        className={
                                            defaultClasses.DropDownWrapp_signup
                                        }
                                    >
                                        <React.Fragment>
                                            {isSignedIn && (
                                                <Button className={defaultClasses.signout_btn} onClick={handleSignOut}>{"Sign Out"}</Button>
                                            )}
                                            {!isSignedIn && (
                                                <span>
                                                    <NavTrigger>
                                                        Login
                                                    </NavTrigger>
                                                </span>
                                            )}
                                        </React.Fragment>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* End of section-upper-header  */}
            <div className={defaultClasses.main_navigation}>
                <div className="container">
                    <div className="row">
                        <div className="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <ul className={defaultClasses.ced_megamenu}>
                                {navItems}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    );
    } else{
        return "";
    }
};

Header.propTypes = {
    classes: shape({
        closed: string,
        logo: string,
        open: string,
        primaryActions: string,
        secondaryActions: string,
        toolbar: string
    })
};

export default Header;
