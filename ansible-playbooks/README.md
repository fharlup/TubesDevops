# Ansible Playbooks - Healthcare Application

Ansible automation untuk deployment Laravel Healthcare Application dengan Docker.

## Prerequisites

```bash
# Install Ansible
sudo apt update
sudo apt install ansible -y

# Verify installation
ansible --version
```

## Setup

### 1. Clone dan Setup Structure

```bash
mkdir -p ansible/{inventory,playbooks,roles,vars}
cd ansible
```

### 2. Configure Inventory

Edit `inventory/production` dengan IP server kamu:

```ini
[webservers]
web1 ansible_host=YOUR_SERVER_IP ansible_user=ubuntu
```

### 3. Setup SSH Keys

```bash
# Generate SSH key jika belum punya
ssh-keygen -t rsa -b 4096

# Copy ke server
ssh-copy-id ubuntu@YOUR_SERVER_IP

# Test koneksi
ansible webservers -m ping
```

### 4. Configure Variables

Edit `vars/main.yml` dan sesuaikan dengan environment kamu:

```yaml
git_repo: "https://github.com/yourusername/repo.git"
app_port: 8080
db_password: "your_secure_password"
```

### 5. Encrypt Sensitive Data (Optional)

```bash
# Create vault file untuk password
ansible-vault create vars/vault.yml

# Isi dengan:
vault_db_password: your_db_password
vault_app_key: base64:your_app_key

# Edit vault
ansible-vault edit vars/vault.yml
```

## Usage Commands

### Full Deployment (First Time)

```bash
# Deploy everything
ansible-playbook playbooks/main.yml

# Dengan vault password
ansible-playbook playbooks/main.yml --ask-vault-pass

# Specific host
ansible-playbook playbooks/main.yml -l web1
```

### Quick Deploy (Updates)

```bash
# Deploy code changes only
ansible-playbook playbooks/deploy.yml

# Dengan migrations
ansible-playbook playbooks/deploy.yml -e "run_migrations=true"

# Dengan seeders
ansible-playbook playbooks/deploy.yml -e "run_seeders=true"
```

### Rollback

```bash
ansible-playbook playbooks/rollback.yml
# Akan prompt untuk commit hash
```

### Backup

```bash
# Backup database dan files
ansible-playbook playbooks/backup.yml
```

### Health Check

```bash
# Check application status
ansible-playbook playbooks/health-check.yml
```

### Specific Tasks

```bash
# Install Docker only
ansible-playbook playbooks/main.yml --tags docker

# Deploy app only
ansible-playbook playbooks/main.yml --tags application

# Setup monitoring only
ansible-playbook playbooks/main.yml --tags monitoring
```

## Common Commands

```bash
# Check syntax
ansible-playbook playbooks/main.yml --syntax-check

# Dry run
ansible-playbook playbooks/main.yml --check

# Verbose output
ansible-playbook playbooks/main.yml -v
ansible-playbook playbooks/main.yml -vvv  # extra verbose

# List tasks
ansible-playbook playbooks/main.yml --list-tasks

# List hosts
ansible-playbook playbooks/main.yml --list-hosts
```

## Troubleshooting

### Check Connection

```bash
ansible webservers -m ping
ansible webservers -m setup  # Get facts
```

### Manual Commands

```bash
# Run ad-hoc command
ansible webservers -a "docker ps"
ansible webservers -a "systemctl status docker"
```

### Logs

```bash
# Check Docker logs
ssh ubuntu@YOUR_SERVER_IP
cd /opt/healthcare-app
docker-compose logs -f app
```

### Reset

```bash
# Stop all containers
ansible webservers -a "docker-compose -f /opt/healthcare-app/docker-compose.yml down"

# Remove all containers
ansible webservers -a "docker system prune -af"
```

## Project Structure

```
ansible/
├── ansible.cfg              # Ansible configuration
├── inventory/
│   ├── production          # Production servers
│   └── staging             # Staging servers
├── playbooks/
│   ├── main.yml            # Main deployment playbook
│   ├── deploy.yml          # Quick deployment
│   ├── rollback.yml        # Rollback deployment
│   ├── backup.yml          # Backup tasks
│   └── health-check.yml    # Health monitoring
├── roles/
│   ├── common/             # Common setup tasks
│   ├── docker/             # Docker installation
│   ├── application/        # App deployment
│   └── monitoring/         # Prometheus & Grafana
└── vars/
    ├── main.yml            # Variables
    └── vault.yml           # Encrypted secrets
```

## Integration dengan Tim

### Untuk Gabriel (Ansible Control Server)

Playbook ini siap dijalankan dari control server. Pastikan:
- Inventory configured dengan semua target hosts
- SSH keys terdistribusi ke semua nodes
- Ansible installed di control server

### Untuk Hafid (Docker Compose)

Template `docker-compose.yml.j2` akan menggunakan compose file yang sudah dibuat. Copy compose file ke `roles/application/templates/docker-compose.yml.j2`

### Untuk Fajar (Docker Image)

Playbook akan build image dari Dockerfile yang ada di repo. Pastikan Dockerfile sudah ready.

### Untuk Mangkus & Isal (Prometheus & Grafana)

Role monitoring sudah siap. Tinggal sesuaikan:
- `roles/monitoring/templates/prometheus.yml.j2`
- `roles/monitoring/templates/grafana-datasource.yml.j2`

### Untuk Ripa (Kubernetes)

Playbook ini untuk deployment ke VM. Untuk K8s, bisa buat playbook terpisah atau gunakan Ansible untuk setup K8s cluster.

## Notes

- Default app port: 8080
- Default DB port: 3306
- Prometheus port: 9090
- Grafana port: 3000
- Application path: `/opt/healthcare-app`

## Tips

1. **Testing**: Selalu test di staging dulu sebelum production
2. **Backup**: Jalankan backup sebelum deployment besar
3. **Monitoring**: Cek Grafana dashboard setelah deployment
4. **Logs**: Monitor logs saat deployment untuk error
5. **Rollback**: Siapkan rollback plan jika ada issue