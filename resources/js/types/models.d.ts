export interface Creator {
    id: number;
    name: string;
}

export interface Project {
    id: number;
    name: string;
    status: string;
    start_date: string;
    end_date: string;
    value: number;
    creator: Creator;
};

export interface Task {
    id: number;
    title: string;
    status: string;
    due_date: string;
    creator: Creator;
}
