#!/bin/bash
# quick-deploy.sh - Quick deployment script for Healthcare App

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Banner
echo -e "${GREEN}"
cat << "EOF"
╔═══════════════════════════════════════════════════╗
║   Healthcare Application - Ansible Deployment     ║
║                  Team DevOps                      ║
╚═══════════════════════════════════════════════════╝
EOF
echo -e "${NC}"

# Check if Ansible is installed
if ! command -v ansible &> /dev/null; then
    print_error "Ansible is not installed. Please install it first:"
    echo "  sudo apt update && sudo apt install -y ansible"
    exit 1
fi

print_success "Ansible is installed"

# Check if inventory file exists
if [ ! -f "inventory/production" ]; then
    print_error "Inventory file not found!"
    print_info "Please create inventory/production with your server IPs"
    exit 1
fi

# Menu
echo ""
print_info "Select deployment option:"
echo "1) Full Deployment (All Components)"
echo "2) Application Only"
echo "3) Monitoring Only"
echo "4) Kubernetes Deployment "
echo "5) Backup Database & Files"
echo "6) Rollback Application"
echo "7) Health Check"
echo "8) Exit"
echo ""

read -p "Enter your choice [1-8]: " choice

case $choice in
    1)
        print_info "Starting full deployment..."
        ansible-playbook playbooks/main.yml -i inventory/production --ask-vault-pass
        ;;
    2)
        print_info "Deploying application (Docker + Compose)..."
        ansible-playbook playbooks/deploy.yml -i inventory/production --ask-vault-pass
        ;;
    3)
        print_info "Deploying monitoring stack (Prometheus + Grafana)..."
        ansible-playbook playbooks/main.yml -i inventory/production --tags "monitoring" --ask-vault-pass
        ;;
    4)
        print_info "Deploying to Kubernetes..."
        ansible-playbook playbooks/kubernetes.yml -i inventory/production --ask-vault-pass
        ;;
    5)
        print_info "Creating backup..."
        ansible-playbook playbooks/backup.yml -i inventory/production
        ;;
    6)
        print_warning "Starting rollback process..."
        ansible-playbook playbooks/rollback.yml -i inventory/production
        ;;
    7)
        print_info "Running health check..."
        ansible-playbook playbooks/health-check.yml -i inventory/production
        ;;
    8)
        print_info "Exiting..."
        exit 0
        ;;
    *)
        print_error "Invalid option!"
        exit 1
        ;;
esac

# Check exit status
if [ $? -eq 0 ]; then
    echo ""
    print_success "═══════════════════════════════════════════════════"
    print_success "   Deployment completed successfully!"
    print_success "═══════════════════════════════════════════════════"
    echo ""
    print_info "Access your application:"
    echo "  - Application: http://YOUR_SERVER_IP:8080"
    echo "  - phpMyAdmin: http://YOUR_SERVER_IP:8081"
    echo "  - Prometheus: http://YOUR_SERVER_IP:9090"
    echo "  - Grafana: http://YOUR_SERVER_IP:3000"
    echo ""
else
    echo ""
    print_error "═══════════════════════════════════════════════════"
    print_error "   Deployment failed!"
    print_error "═══════════════════════════════════════════════════"
    echo ""
    print_info "Check logs: cat ansible.log"
    echo ""
    exit 1
fi
