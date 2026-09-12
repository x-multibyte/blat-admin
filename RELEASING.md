# Quick Release Reference

## 🚀 发布新版本（3 步）

```bash
# 1. 确保测试通过
composer test

# 2. 创建标签
git tag -a v1.0.0 -m "Release v1.0.0"

# 3. 推送标签（自动化接管）
git push origin v1.0.0
```

✨ 推送标签后，GitHub Actions 自动完成：
- 创建 GitHub Release
- 生成 release notes
- 更新 CHANGELOG.md
- 同步到 Packagist

## 📦 版本号规范

- `v1.0.0` - 正式版本
- `v0.1.0` - 开发版本
- `v1.0.0-beta.1` - 测试版本
- `v1.0.0-rc.1` - 候选版本

遵循 [语义化版本](https://semver.org/lang/zh-CN/):
- **主版本** (MAJOR): 不兼容的 API 变更
- **次版本** (MINOR): 向下兼容的新功能
- **修订号** (PATCH): 向下兼容的 bug 修复

## 🏷️ PR 标签（用于自动分类）

为 PR 添加标签以改进 release notes：

- `breaking` - Breaking Changes
- `enhancement` - Enhancements
- `bug` - Bug Fixes
- `documentation` - Documentation
- `dependencies` - Dependencies
- `maintenance` - Maintenance
- `skip-changelog` - 不包含在 changelog 中

## 📚 详细文档

查看 [.github/RELEASE_GUIDE.md](.github/RELEASE_GUIDE.md) 了解完整的发布流程、故障排查和最佳实践。

## 🔄 回滚版本

```bash
# 删除标签
git tag -d v1.0.0
git push origin :refs/tags/v1.0.0

# 删除 Release
gh release delete v1.0.0 --yes
```
