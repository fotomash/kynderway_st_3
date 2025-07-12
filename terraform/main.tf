provider "aws" {
  region = var.aws_region
}

variable "aws_region" {
  description = "AWS region"
  type        = string
  default     = "us-east-1"
}

variable "task_definition" {
  description = "Existing ECS task definition to run"
  type        = string
}

resource "aws_ecs_cluster" "kynderway" {
  name = "kynderway"
}

resource "aws_ecs_service" "kynderway_service" {
  name            = "kynderway-service"
  cluster         = aws_ecs_cluster.kynderway.id
  task_definition = var.task_definition
  desired_count   = 3
}
