module.exports = {
  rules: {
    'type-enum': [
      2,
      'always',
      [
        'feat',
        'fix',
        'docs',
        'style',
        'refactor',
        'test',
        'chore',
        'build',
        'ci',
        'revert',
      ],
    ],
    'type-empty': [2, 'never'],
    'subject-empty': [2, 'never'],
  },
};
