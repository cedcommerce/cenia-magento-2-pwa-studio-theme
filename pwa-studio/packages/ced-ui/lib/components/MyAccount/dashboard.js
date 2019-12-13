import React from 'react';
import { func, shape, string } from 'prop-types';

import { mergeClasses } from '../../classify';
import defaultClasses from './myAccount.css';
import { useDashboard } from '@magento/peregrine/lib/talons/MyAccount/useDashboard';

const Dashboard = props => {
    const classes = mergeClasses(defaultClasses, props.classes);
    
    const talonProps = useDashboard();

    const { name, email } = talonProps;

    return (
        <div className={classes.columns}>
            <div className="column main">
                <div className="page-title-wrapper">
                    <h1 className="page-title">
                        <span className="base">My Account</span>
                    </h1>
                </div>
                <div className="block block-dashboard-info">
                    <div className="block-title">
                        <strong>Account Information</strong>
                    </div>
                    <div className="block-content">
                        <div className="box box-information">
                            <strong className="box-title">
                                <span>Contact Information</span>
                            </strong>
                            <div className="box-content">
                                <p>
                                    Gaurav <br />
                                    gaurav@gmail.com
                                    <br />
                                </p>
                            </div>
                            <div className="box-actions">
                                <a
                                    className="action edit"
                                    href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/customer/account/edit/"
                                >
                                    <span>Edit</span>
                                </a>
                                <a
                                    href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/customer/account/edit/changepass/1/"
                                    className="action change-password"
                                >
                                    Change Password
                                </a>
                            </div>
                        </div>
                        <div className="box box-newsletter">
                            <strong className="box-title">
                                <span>Newsletters</span>
                            </strong>
                            <div className="box-content">
                                <p>You aren't subscribed to our newsletter.</p>
                            </div>
                            <div className="box-actions">
                                <a
                                    className="action edit"
                                    href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/newsletter/manage/"
                                >
                                    <span>Edit</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="block block-dashboard-addresses">
                    <div className="block-title">
                        <strong>Address Book</strong>
                        <a
                            className="action edit"
                            href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/customer/address/"
                        >
                            <span>Manage Addresses</span>
                        </a>
                    </div>
                    <div className="block-content">
                        <div className="box box-billing-address">
                            <strong className="box-title">
                                <span>Default Billing Address</span>
                            </strong>
                            <div className="box-content">
                                <address>
                                    Veronica Costello
                                    <br />
                                    6146 Honey Bluff Parkway
                                    <br />
                                    Calder, Michigan, 49628-7978
                                    <br />
                                    United States
                                    <br />
                                    T:{' '}
                                    <a href="tel:(555) 229-3326">
                                        (555) 229-3326
                                    </a>
                                </address>
                            </div>
                            <div className="box-actions">
                                <a
                                    className="action edit"
                                    href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/customer/address/edit/id/1/"
                                    data-ui-id="default-billing-edit-link"
                                >
                                    <span>Edit Address</span>
                                </a>
                            </div>
                        </div>
                        <div className="box box-shipping-address">
                            <strong className="box-title">
                                <span>Default Shipping Address</span>
                            </strong>
                            <div className="box-content">
                                <address>
                                    Veronica Costello
                                    <br />
                                    6146 Honey Bluff Parkway
                                    <br />
                                    Calder, Michigan, 49628-7978
                                    <br />
                                    United States
                                    <br />
                                    T:{' '}
                                    <a href="tel:(555) 229-3326">
                                        (555) 229-3326
                                    </a>
                                </address>
                            </div>
                            <div className="box-actions">
                                <a
                                    className="action edit"
                                    href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/customer/address/edit/id/1/"
                                    data-ui-id="default-shipping-edit-link"
                                >
                                    <span>Edit Address</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="block block-dashboard-orders">
                    <div className="block-title order">
                        <strong>Recent Orders</strong>
                        <a
                            className="action view"
                            href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/sales/order/history/"
                        >
                            <span>View All</span>
                        </a>
                    </div>
                    <div className="block-content">
                        <div className="table-wrapper orders-recent">
                            <table
                                className="data table table-order-items recent"
                                id="my-orders-table"
                            >
                                <caption className="table-caption">
                                    Recent Orders
                                </caption>
                                <thead>
                                    <tr>
                                        <th scope="col" className="col id">
                                            Order #
                                        </th>
                                        <th scope="col" className="col date">
                                            Date
                                        </th>
                                        <th
                                            scope="col"
                                            className="col shipping"
                                        >
                                            Ship To
                                        </th>
                                        <th scope="col" className="col total">
                                            Order Total
                                        </th>
                                        <th scope="col" className="col status">
                                            Status
                                        </th>
                                        <th scope="col" className="col actions">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td
                                            data-th="Order #"
                                            className="col id"
                                        >
                                            000000002
                                        </td>
                                        <td data-th="Date" className="col date">
                                            7/30/19
                                        </td>
                                        <td
                                            data-th="Ship To"
                                            className="col shipping"
                                        >
                                            Veronica Costello
                                        </td>
                                        <td
                                            data-th="Order Total"
                                            className="col total"
                                        >
                                            <span className="price">
                                                $39.64
                                            </span>
                                        </td>
                                        <td
                                            data-th="Status"
                                            className="col status"
                                        >
                                            Closed
                                        </td>
                                        <td
                                            data-th="Actions"
                                            className="col actions"
                                        >
                                            <a
                                                href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/sales/order/view/order_id/2/"
                                                className="action view"
                                            >
                                                <span>View Order</span>
                                            </a>
                                            <a
                                                href="/"
                                                className="action order"
                                            >
                                                <span>Reorder</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            data-th="Order #"
                                            className="col id"
                                        >
                                            000000001
                                        </td>
                                        <td data-th="Date" className="col date">
                                            7/30/19
                                        </td>
                                        <td
                                            data-th="Ship To"
                                            className="col shipping"
                                        >
                                            Veronica Costello
                                        </td>
                                        <td
                                            data-th="Order Total"
                                            className="col total"
                                        >
                                            <span className="price">
                                                $36.39
                                            </span>
                                        </td>
                                        <td
                                            data-th="Status"
                                            className="col status"
                                        >
                                            Processing
                                        </td>
                                        <td
                                            data-th="Actions"
                                            className="col actions"
                                        >
                                            <a
                                                href="http://192.168.0.209/wallet/pwa/m2.3.2_sample_data/sales/order/view/order_id/1/"
                                                className="action view"
                                            >
                                                <span>View Order</span>
                                            </a>
                                            <a href="/" className="action">
                                                <span>Reorder</span>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Dashboard;

Dashboard.propTypes = {
    classes: shape({
        actions: string,
        root: string,
        subtitle: string,
        title: string,
        user: string
    })
};
