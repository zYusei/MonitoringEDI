pipeline {
    agent any

    stages {
        stage('Clean Workspace') {
            steps {
                cleanWs()
            }
        }
        stage('Checkout SCM') {
            steps {
                git branch: 'main', credentialsId: 'github', url: 'https://github.com/zYusei/MonitoringEDI.git'
            }
        }
        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("monitoringedi:latest")
                }
            }
        }
        stage('SonarQube Analysis') {
            steps {
                withSonarQubeEnv('Sonar-Server') {
                    script {
                        def scannerHome = tool 'SonarScanner';
                        sh "${scannerHome}/bin/sonar-scanner \
                            -Dsonar.projectKey=Monitoring \
                            -Dsonar.sources=."
                    }
                }
            }
        }
        stage('Security Scan with Trivy') {
            steps {
                script {
                    // build the latest Docker image
                    sh "docker build -t zyuseiii/monitoringedi:latest ."

                    // Run Trivy to scan the Docker image for vulnerabilities
                    sh "trivy image zyuseiii/monitoringedi:latest"
                }
            }
        }
        stage('Push Docker Image') {
            steps {
                script {
                    withDockerRegistry(credentialsId: 'docker', toolName:'docker') {
                        sh "docker build -t monitoringedi ."
                        sh "docker tag monitoringedi zyuseiii/monitoringedi:latest"
                        sh "docker push zyuseiii/monitoringedi:latest"
                    }
                }
            }
        }
        stage('Run Docker Containers') {
            steps {
                script {
                    sh 'docker-compose up --build -d'
                    sh 'docker-compose down'
                }
            }
        }
        stage('Run Tests') {
            steps {
                sh 'docker login -u autumnsummrs64@gmail.com -p Dauphindu99@'


                sh "docker pull zyuseiii/monitoringedi:latest"


                sh "docker inspect zyuseiii/monitoringedi:latest"


                sh "docker run --name test-container -d zyuseiii/monitoringedi:latest"


                sh "docker exec test-container php -v"


                sh "docker stop test-container && docker rm test-container"
            }
        }
        stage('Deploy to EC2') {
            steps {
                script {
                    def ec2Instance = [
                        name: 'Monitoring',
                        host: '13.38.130.124',
                        user: 'ubuntu',
                        credentialsId: 'SSH-KEY' // ID of SSH credentials
                    ]

                    // Execute commands on the EC2 instance
                    sshagent(credentials: ['SSH-KEY']) {
                        sh '''
                            ssh -o StrictHostKeyChecking=no ubuntu@13.38.130.124 'cd /home/ubuntu/MontoringEDI && sudo docker-compose up --build -d'
                        '''
                    }
                }
            }
        }
    }

    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed!'
        }
    }
}
