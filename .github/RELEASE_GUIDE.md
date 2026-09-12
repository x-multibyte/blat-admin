# Release Guide

本指南说明如何为 `x-multibyte/blat-admin` 创建新版本发布。

## 自动化流程

项目现在配置了完全自动化的 release 流程：

### 1. 当推送 Git Tag 时自动触发

当你推送一个符合 `v*` 格式的标签时（例如 `v1.0.0`），GitHub Actions 会自动：

- 创建 GitHub Release
- 从标记的 PR 生成 release notes（基于 `.github/release.yml` 配置）
- 自动检测预发布版本（alpha/beta/rc）

### 2. Release 创建后自动更新 CHANGELOG

当 Release 发布后，`update-changelog.yml` 会自动：

- 将 release notes 写入 `CHANGELOG.md`
- 提交更改到 main 分支

## 发布新版本的步骤

### 准备阶段

1. **确保所有测试通过**
   ```bash
   composer test
   ```

2. **检查待发布的更改**
   ```bash
   git log --oneline --no-merges v0.1.0..HEAD  # 如果已有标签
   git log --oneline --no-merges              # 如果是首次发布
   ```

3. **更新 CHANGELOG.md（可选）**
   
   虽然 release notes 会自动生成，但建议手动整理 CHANGELOG：
   ```markdown
   ## [v1.0.0](https://github.com/x-multibyte/blat-admin/compare/v0.1.0...v1.0.0) - 2026-09-12
   
   ### Added
   - 新功能描述
   
   ### Fixed
   - Bug 修复描述
   
   ### Changed
   - 变更描述
   ```

### 发布阶段

4. **创建并推送标签**
   ```bash
   # 创建标签
   git tag -a v1.0.0 -m "Release v1.0.0"
   
   # 推送标签
   git push origin v1.0.0
   ```

5. **自动化流程接管**
   
   推送标签后，GitHub Actions 会自动：
   - 运行 `release.yml` workflow
   - 创建 GitHub Release
   - 生成 release notes
   - 触发 `update-changelog.yml`
   - 更新 CHANGELOG.md

### 验证阶段

6. **验证发布**
   - 访问 https://github.com/x-multibyte/blat-admin/releases
   - 检查 release notes 是否正确
   - 确认 CHANGELOG.md 已更新
   - 验证 Packagist 是否已同步（通常几分钟内自动同步）

## 版本号规范

遵循 [语义化版本](https://semver.org/lang/zh-CN/)：

- **主版本号（MAJOR）**: 不兼容的 API 变更（例如 `v1.0.0` → `v2.0.0`）
- **次版本号（MINOR）**: 向下兼容的新功能（例如 `v1.0.0` → `v1.1.0`）
- **修订号（PATCH）**: 向下兼容的 bug 修复（例如 `v1.0.0` → `v1.0.1`）

### 预发布版本

- **Alpha**: `v1.0.0-alpha.1` - 内部测试版本
- **Beta**: `v1.0.0-beta.1` - 公开测试版本
- **RC**: `v1.0.0-rc.1` - 候选发布版本

预发布版本会自动标记为 "Pre-release" 在 GitHub。

## Release Notes 分类

根据 `.github/release.yml` 配置，PR 会按以下标签分类：

- `breaking` → **Breaking Changes**
- `enhancement` → **Enhancements**
- `bug` → **Bug Fixes**
- `documentation` → **Documentation**
- `dependencies` → **Dependencies**
- `maintenance` → **Maintenance**
- `skip-changelog` → 从 changelog 中排除
- 其他 → **Other Changes**

**建议**: 为每个 PR 添加适当的标签，以便自动生成清晰的 release notes。

## 回滚版本

如果需要回滚或删除版本：

```bash
# 删除本地标签
git tag -d v1.0.0

# 删除远程标签
git push origin :refs/tags/v1.0.0

# 在 GitHub 上删除 Release
gh release delete v1.0.0 --yes
```

## 首次发布 (v0.1.0)

对于首次发布，建议：

1. 确保所有核心功能已完成并测试通过
2. 更新 README.md 确保安装和使用说明完整
3. 创建 `v0.1.0` 标签开始版本历史
4. 后续版本可以从 `v0.1.0` 开始比较

## 故障排查

### 如果 workflow 失败

1. 检查 GitHub Actions 日志：https://github.com/x-multibyte/blat-admin/actions
2. 确认标签格式正确（必须以 `v` 开头）
3. 验证 workflow 文件语法正确

### 如果 CHANGELOG 未更新

1. 检查 `update-changelog.yml` workflow 是否运行
2. 确认有 `contents: write` 权限
3. 手动运行 workflow 或手动更新 CHANGELOG

## 相关文件

- `.github/workflows/release.yml` - 自动创建 release
- `.github/workflows/update-changelog.yml` - 自动更新 CHANGELOG
- `.github/release.yml` - Release notes 分类配置
- `CHANGELOG.md` - 版本变更记录
