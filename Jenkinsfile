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
        stage('Build and push Docker Image') {
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
                }
            }
        }
        stage('Run Tests') {
            steps {
                sh 'docker login -u autumnsummrs64@gmail.com -p Dauphindu99@'

                // Pull the Docker image
                sh "docker pull zyuseiii/monitoringedi:latest"

                // Stop and remove the test container
                sh "docker stop test-container && docker rm test-container"
            }
        }
        stage('Deploy to EC2') {
            steps {
                script {
                    def ec2Instance = [
                        name: 'ec2-instance',
                        host: '35.180.190.54',
                        user: 'ubuntu',
                        credentialsId: 'SSH-KEY' // ID of SSH credentials
                    ]

                    // Execute commands on the EC2 instance
                    sshagent(credentials: ['SSH-KEY']) {
                        sh '''
                            ssh -o StrictHostKeyChecking=no ubuntu@35.180.190.54 'cd /home/ubuntu/MontoringEDI && sudo docker-compose up --build -d'
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
        always {
            sh 'docker-compose down'
        }
    }
}
