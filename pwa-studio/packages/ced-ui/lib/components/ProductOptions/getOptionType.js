const customAttributes = {
    color: 'swatch'
};

export default ({ attribute_code: code } = {}) => customAttributes[code];
