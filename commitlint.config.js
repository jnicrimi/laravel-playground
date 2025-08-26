module.exports = {
  rules: {
    'type-enum': [
      2,
      'always',
      [
        'feat',
        'fix',
        'refactor',
        'docs',
        'test',
        'style',
        'build',
        'ci',
        'perf',
        'chore',
        'revert'
      ]
    ],
    'type-empty': [2, 'never'],
    'subject-empty': [2, 'never']
  }
};
