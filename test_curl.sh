#!/bin/bash

echo "=== OpenRouter API cURL Test ==="
echo ""

# Test data
TEST_MESSAGE="Hello! Please respond with just 'API is working' if you can see this message."

# Test 1: Localhost (als je een lokale webserver hebt)
echo "Testing localhost:8000..."
curl -X POST \
  -H "Content-Type: application/json" \
  -d "{\"message\":\"$TEST_MESSAGE\"}" \
  http://localhost:8000/api/openrouter/index.php \
  2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "\n✅ localhost:8000 test completed"
else
    echo -e "\n❌ localhost:8000 not accessible"
fi

echo -e "\n---\n"

# Test 2: Localhost poort 80
echo "Testing localhost:80..."
curl -X POST \
  -H "Content-Type: application/json" \
  -d "{\"message\":\"$TEST_MESSAGE\"}" \
  http://localhost/api/openrouter/index.php \
  2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "\n✅ localhost:80 test completed"
else
    echo -e "\n❌ localhost:80 not accessible"
fi

echo -e "\n---\n"

# Test 3: Direct file test (als je de test_api.php wilt runnen)
echo "Instructions for manual testing:"
echo "1. Start a PHP development server:"
echo "   cd /mnt/c/Projects/Academics/TLE1"
echo "   php -S localhost:8000"
echo ""
echo "2. Then run this cURL command:"
echo "   curl -X POST -H 'Content-Type: application/json' -d '{\"message\":\"Hello test\"}' http://localhost:8000/api/openrouter/index.php"
echo ""
echo "3. Or test the PHP script directly (if PHP is available):"
echo "   php api/openrouter/test_api.php"

echo -e "\n=== Test Complete ==="