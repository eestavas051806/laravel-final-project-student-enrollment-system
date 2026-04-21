#!/bin/bash
# ─────────────────────────────────────────────────────────────────
# push-to-github.sh
# Run this script to push the project to your GitHub repository.
#
# Usage:
#   chmod +x push-to-github.sh
#   ./push-to-github.sh https://github.com/YOUR_USERNAME/student-enrollment-system.git
# ─────────────────────────────────────────────────────────────────

REPO_URL=${1:-""}

if [ -z "$REPO_URL" ]; then
  echo ""
  echo "❌  No repository URL provided."
  echo ""
  echo "Usage: ./push-to-github.sh https://github.com/YOUR_USERNAME/student-enrollment-system.git"
  echo ""
  echo "Steps to create the repo first:"
  echo "  1. Go to https://github.com/new"
  echo "  2. Repository name: student-enrollment-system"
  echo "  3. Keep it Public (or Private)"
  echo "  4. Do NOT initialize with README, .gitignore, or license"
  echo "  5. Click 'Create repository'"
  echo "  6. Copy the HTTPS URL and re-run this script with it"
  echo ""
  exit 1
fi

echo ""
echo "🔗  Setting remote origin → $REPO_URL"
git remote remove origin 2>/dev/null || true
git remote add origin "$REPO_URL"

echo "📤  Pushing to GitHub (branch: main)..."
git push -u origin main

if [ $? -eq 0 ]; then
  echo ""
  echo "✅  Successfully pushed to GitHub!"
  echo "    $REPO_URL"
  echo ""
else
  echo ""
  echo "❌  Push failed. Make sure you:"
  echo "    • Are authenticated (gh auth login OR use a Personal Access Token)"
  echo "    • The repository exists and is empty"
  echo ""
fi
