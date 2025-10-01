// Import jest-dom matchers
import '@testing-library/jest-dom';

// Mock Laravel Echo and Pusher
global.Echo = {
    channel: jest.fn(() => ({
        listen: jest.fn(),
        stopListening: jest.fn(),
    })),
    private: jest.fn(() => ({
        listen: jest.fn(),
        stopListening: jest.fn(),
    })),
    leave: jest.fn(),
    disconnect: jest.fn(),
};

global.Pusher = jest.fn();

// Mock axios
global.axios = {
    defaults: {
        headers: {
            common: {},
        },
    },
    post: jest.fn(),
    get: jest.fn(),
    put: jest.fn(),
    delete: jest.fn(),
};

// Mock fetch
global.fetch = jest.fn();

// Mock console methods to avoid noise in tests
global.console = {
    ...console,
    error: jest.fn(),
    warn: jest.fn(),
    log: jest.fn(),
};

// Mock window.location (before other setup)
delete window.location;
window.location = {
    hostname: 'localhost',
    href: 'http://localhost:8000',
    pathname: '/',
    reload: jest.fn(),
    replace: jest.fn(),
};

// Mock DOM methods - don't override querySelector globally as it's needed by jsdom
global.document.addEventListener = jest.fn((event, handler) => {
    // Store event handlers for testing if needed
    if (event === 'DOMContentLoaded') {
        // Execute DOMContentLoaded handlers immediately in tests
        setTimeout(() => handler(), 0);
    }
});
global.document.removeEventListener = jest.fn();

// Mock FormData
global.FormData = class FormData {
    constructor() {
        this.data = {};
    }

    append(key, value) {
        this.data[key] = value;
    }

    get(key) {
        return this.data[key];
    }
};
