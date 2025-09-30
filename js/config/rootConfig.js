/*
================================================================================
ROOT CONFIGURATION - SHARED DESIGN TOKENS
================================================================================
Centralized design system tokens shared across all components
*/

const rootColors = {
    primary: '#4CAF50',
    primaryHover: '#45a049',
    secondary: '#2196F3',
    background: '#f5f5f5',
    surface: '#ffffff',
    error: '#c62828',
    errorBg: '#ffebee',
    success: '#2e7d32',
    successBg: '#e8f5e8',
    text: '#333',
    textSecondary: '#555',
    textMuted: '#666',
    border: '#ddd',
    borderAccent: '#4CAF50',
    overlay: 'rgba(0,0,0,0.1)'
};

const rootSpacing = {
    xs: '5px',
    sm: '10px',
    md: '15px',
    lg: '20px',
    xl: '30px',
    xxl: '50px'
};

const rootTypography = {
    fontFamily: 'Arial, sans-serif',
    fontSize: {
        small: '12px',
        base: '14px',
        medium: '16px',
        large: '18px',
        xl: '24px'
    },
    fontWeight: {
        normal: 400,
        medium: 500,
        bold: 700
    },
    lineHeight: {
        tight: 1.2,
        normal: 1.5,
        relaxed: 1.6
    }
};

const rootBorderRadius = {
    sm: '4px',
    md: '5px',
    lg: '8px',
    xl: '10px'
};

const rootShadows = {
    sm: '0 1px 3px rgba(0,0,0,0.1)',
    md: '0 2px 10px rgba(0,0,0,0.1)',
    lg: '0 4px 20px rgba(0,0,0,0.15)'
};

// Export all root configurations
export {
    rootColors,
    rootSpacing,
    rootTypography,
    rootBorderRadius,
    rootShadows
};