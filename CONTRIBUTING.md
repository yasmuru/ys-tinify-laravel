# Contributing to Laravel Tinify

Thank you for considering contributing to this package! Here are some guidelines to help you get started.

## Development Setup

1. **Fork and Clone**
   ```bash
   git clone https://github.com/your-username/ys-tinify-laravel.git
   cd ys-tinify-laravel
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Run Tests**
   ```bash
   composer test
   ```

## Code Style

This package follows PSR-12 coding standards and uses:
- Strict types (`declare(strict_types=1)`)
- Type hints for all parameters
- Return type declarations
- PHPDoc blocks for documentation

## Making Changes

1. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   # or
   git checkout -b fix/bug-description
   ```

2. **Make Your Changes**
   - Write clean, documented code
   - Follow existing code style
   - Add tests for new features
   - Update documentation if needed

3. **Run Tests**
   ```bash
   composer test
   ```

4. **Commit Your Changes**
   ```bash
   git add .
   git commit -m "Description of changes"
   ```

   Use clear, descriptive commit messages:
   - `feat: add new compression method`
   - `fix: resolve S3 upload issue`
   - `docs: update README examples`
   - `test: add tests for S3 functionality`

5. **Push and Create PR**
   ```bash
   git push origin your-branch-name
   ```
   
   Then create a Pull Request on GitHub.

## Testing

- Write tests for any new features
- Ensure all existing tests pass
- Aim for good test coverage
- Tests are located in the `tests/` directory

## Documentation

- Update README.md for user-facing changes
- Update CHANGELOG.md following the existing format
- Add PHPDoc comments to new methods
- Update UPGRADE.md for breaking changes

## Pull Request Guidelines

- Keep PRs focused on a single feature/fix
- Provide a clear description of changes
- Reference related issues
- Ensure CI tests pass
- Be responsive to feedback

## Reporting Issues

- Use the GitHub issue tracker
- Search existing issues first
- Provide detailed reproduction steps
- Include Laravel and PHP versions
- Share relevant code samples

## Code of Conduct

- Be respectful and constructive
- Welcome newcomers
- Focus on what is best for the community
- Show empathy towards others

## Questions?

Feel free to open an issue for any questions about contributing!

---

Thank you for contributing! 🎉
