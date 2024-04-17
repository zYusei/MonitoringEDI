pipeline {
    agent any

    stages {
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
                echo 'Running tests...'

                sh 'docker login -u autumnsummrs64@gmail.com -p Dauphindu99@'


                sh "docker pull monitoringedi:latest"


                sh "docker inspect monitoringedi:latest"


                sh "docker run --name test-container -d monitoringedi:latest"


                sh "docker exec test-container php -v"


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