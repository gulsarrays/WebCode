function shouldContinue () {
    if [ "$noprompt" ] && [ "$#" = "1" ]; then
        if [ "$1" = "yes" ]; then
            echo "DEFAULT: yes"
            return 0
        else
            echo "DEFAULT: no"
            return 1
        fi
    fi

    while true; do
        echo "Enter \"yes\" or \"no\": "
        read response
        case $response
        in
            Y*) return 0 ;;
            y*) return 0 ;;
            N*) return 1 ;;
            n*) return 1 ;;
            *)
        esac
    done
}
php /home/ubuntu/CoreEngineRoom/composer.phar self-update
php /home/ubuntu/CoreEngineRoom/composer.phar install --dry-run --optimize-autoloader

echo "Update to latest changes? [y/n]"

if shouldContinue "yes"; then
    php /home/ubuntu/CoreEngineRoom/composer.phar install --optimize-autoloader
fi
