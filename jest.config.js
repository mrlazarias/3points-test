export default {
    // Use jsdom environment for DOM testing
    testEnvironment: 'jsdom',

    // Setup files to run before each test file
    setupFilesAfterEnv: ['<rootDir>/tests/js/setup.js'],

    // Module name mapping for imports
    moduleNameMapper: {
        '^@/(.*)$': '<rootDir>/resources/js/$1',
        '^~/(.*)$': '<rootDir>/resources/$1',
    },

    // Test file patterns
    testMatch: ['<rootDir>/tests/js/**/*.test.js', '<rootDir>/tests/js/**/*.spec.js'],

    // Transform files
    transform: {
        '^.+\\.js$': 'babel-jest',
    },

    // Files to ignore
    testPathIgnorePatterns: ['/node_modules/', '/vendor/', '/storage/', '/bootstrap/cache/'],

    // Coverage configuration
    collectCoverageFrom: [
        'resources/js/**/*.js',
        'resources/views/**/*.blade.php',
        '!resources/js/bootstrap.js', // Skip bootstrap as it's mostly configuration
    ],

    // Coverage thresholds
    coverageThreshold: {
        global: {
            branches: 50,
            functions: 50,
            lines: 50,
            statements: 50,
        },
    },
};
